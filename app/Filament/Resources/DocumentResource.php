<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DocumentResource\Pages;
use App\Models\Document;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\TernaryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Notifications\Notification;
use Filament\Forms\Get;

class DocumentResource extends Resource
{
    protected static ?string $model = Document::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $label = 'ឯកសារ';
    protected static ?string $pluralLabel = 'ឯកសារ';
    protected static ?string $navigationLabel = 'ឯកសារ';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('ព័ត៌មានទូទៅ')
                    ->description('បំពេញព័ត៌មានទូទៅរបស់ឯកសារ')
                    ->icon('heroicon-m-information-circle')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\Select::make('type')
                                    ->label('ប្រភេទឯកសារ')
                                    ->placeholder('ជ្រើសរើសប្រភេទឯកសារ')
                                    ->options([
                                        'លិខិតចេញ' => 'លិខិតចេញ',
                                        'លិខិតចូល' => 'លិខិតចូល',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->live(),

                                Forms\Components\DatePicker::make('date')
                                    ->label('កាលបរិច្ឆេទឯកសារ')
                                    ->required()
                                    ->default(now())
                                    ->native(false)
                                    ->displayFormat('d/m/Y')
                                    ->live(),
                            ]),

                        Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('number')
                                    ->label('លេខរាង')
                                    ->placeholder('បញ្ចូលលេខរាង')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Get $get, ?string $context = null) {
                                        if (!$state || !$get('date') || !$get('type')) {
                                            return;
                                        }

                                        // Get current record ID if editing
                                        $recordId = null;
                                        if ($context === 'edit') {
                                            try {
                                                $recordId = request()->route('record');
                                            } catch (\Exception $e) {
                                                return;
                                            }
                                        }

                                        // Check for duplicates in the same year AND same type
                                        $isDuplicateSameType = Document::isDuplicateNumberInSameYearAndType(
                                            $state,
                                            $get('date'),
                                            $get('type'),
                                            $recordId
                                        );

                                        if ($isDuplicateSameType) {
                                            $message = Document::getDuplicateMessage($state, $get('date'), $get('type'));

                                            Notification::make()
                                                ->title('❌ លេខឯកសារមានរួចហើយ!')
                                                ->body($message)
                                                ->danger()
                                                ->persistent()
                                                ->send();
                                        } else {
                                            // Check if same number exists in same year but different type
                                            $differentTypeMessage = Document::getDifferentTypeMessage($state, $get('date'), $get('type'));
                                            if ($differentTypeMessage) {
                                                Notification::make()
                                                    ->title('ℹ️ ព័ត៌មានបន្ថែម')
                                                    ->body($differentTypeMessage)
                                                    ->info()
                                                    ->duration(7000)
                                                    ->send();
                                            }

                                            // Show info about other years if any (but only when creating)
                                            if ($context !== 'edit') {
                                                $sameNumberDocs = Document::getDocumentsWithSameNumber($state, $recordId);
                                                if ($sameNumberDocs->count() > 0) {
                                                    $years = $sameNumberDocs->pluck('date')->map(fn($date) => $date->year)->unique()->sort();

                                                    Notification::make()
                                                        ->title('📅 ឆ្នាំផ្សេងទៀត')
                                                        ->body("លេខឯកសារនេះមានរួចហើយក្នុងឆ្នាំ: " . $years->implode(', '))
                                                        ->info()
                                                        ->duration(5000)
                                                        ->send();
                                                }
                                            }
                                        }
                                    })
                                    ->rules([
                                        'required',
                                        'string',
                                        'max:255',
                                        function () {
                                            return function (string $attribute, $value, \Closure $fail) {
                                                if (!$value) return;

                                                // Get form data safely
                                                $data = collect(request()->all())
                                                    ->merge(request()->input('components.0.snapshot.data', []))
                                                    ->merge(request()->input('data', []))
                                                    ->toArray();

                                                $date = $data['date'] ?? null;
                                                $type = $data['type'] ?? null;
                                                $recordId = null;

                                                // Try to get record ID for edit context
                                                try {
                                                    $recordId = request()->route('record');
                                                } catch (\Exception $e) {
                                                    // Ignore error for create context
                                                }

                                                // Check for same year AND same type duplicate
                                                if ($date && $type && Document::isDuplicateNumberInSameYearAndType($value, $date, $type, $recordId)) {
                                                    $message = Document::getDuplicateMessage($value, $date, $type);
                                                    $fail($message);
                                                }
                                            };
                                        },
                                    ]),

                                Forms\Components\TextInput::make('second_number')
                                    ->label('អត្តលេខ')
                                    ->placeholder('បញ្ចូលអត្តលេខ')
                                    ->maxLength(255),
                            ]),

                        Forms\Components\TextInput::make('source_file')
                            ->label('ប្រភពឯកសារ')
                            ->placeholder('បញ្ចូលប្រភពឯកសារ')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ]),

                Section::make('ឯកសារភ្ជាប់')
                    ->description('ភ្ជាប់ឯកសារ PDF ឬរូបភាព')
                    ->icon('heroicon-m-paper-clip')
                    ->schema([
                        Forms\Components\FileUpload::make('files')
                            ->label('ឯកសារភ្ជាប់')
                            ->multiple()
                            ->acceptedFileTypes(['application/pdf', 'image/*'])
                            ->directory('documents')
                            ->required()
                            ->maxFiles(10)
                            ->maxSize(10240) // 10MB
                            ->uploadingMessage('កំពុងបញ្ចូលឯកសារ...')
                            ->hint('អ្នកអាចបញ្ចូលឯកសារបានច្រើនជាមួយគ្នា (PDF ឬរូបភាព) - អតិបរមា 10MB ក្នុងមួយឯកសារ')
                            ->hintColor('success')
                            ->columnSpanFull(),
                    ]),

                Section::make('ព័ត៌មានបន្ថែម')
                    ->description('ព័ត៌មានលម្អិតបន្ថែម')
                    ->icon('heroicon-m-document-text')
                    ->collapsible()
                    ->collapsed()
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('ការពិពណ៌នាអំពីឯកសារ')
                            ->placeholder('បញ្ចូលការពិពណ៌នាលម្អិតអំពីឯកសារនេះ...')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('other')
                            ->label('កំណត់ចំណាំផ្សេងៗ')
                            ->placeholder('បញ្ចូលកំណត់ចំណាំបន្ថែមប្រសិនបើមាន...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('ប្រភេទ')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'លិខិតចេញ' => 'info',
                        'លិខិតចូល' => 'success',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('number')
                    ->label('លេខរាង')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
                    ->copyable()
                    ->copyMessage('បានចម្លងលេខរាង')
                    ->color('primary')
                    ->description(function (Document $record) {
                        // Show year and if there are duplicates in same year
                        $year = $record->date->year;
                        $sameYearDocs = Document::getDocumentsWithSameNumberInYear($record->number, $year, $record->id);

                        if ($sameYearDocs->count() > 0) {
                            $types = $sameYearDocs->pluck('type')->unique();
                            return "ឆ្នាំ {$year} • ប្រភេទផ្សេង: " . $types->implode(', ');
                        }

                        return "ឆ្នាំ {$year}";
                    }),

                Tables\Columns\TextColumn::make('second_number')
                    ->label('អត្តលេខ')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->copyMessage('បានចម្លងអត្តលេខ')
                    ->placeholder('មិនមាន')
                    ->color('gray'),

                Tables\Columns\TextColumn::make('date')
                    ->label('កាលបរិច្ឆេទ')
                    ->date('d/m/Y')
                    ->sortable()
                    ->color('gray')
                    ->description(function (Document $record) {
                        // Check for same number in other years
                        $sameNumberDocs = Document::getDocumentsWithSameNumber($record->number, $record->id);
                        if ($sameNumberDocs->count() > 0) {
                            $years = $sameNumberDocs->pluck('date')->map(fn($date) => $date->year)->unique()->sort();
                            return '🗓️ ឆ្នាំផ្សេង: ' . $years->take(2)->implode(', ');
                        }
                        return null;
                    }),

                Tables\Columns\TextColumn::make('source_file')
                    ->label('ប្រភពឯកសារ')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('files_count')
                    ->label('ឯកសារ')
                    ->getStateUsing(function (Document $record) {
                        $count = count($record->files);
                        $status = $record->hasValidFiles() ? '✅' : '⚠️';
                        return "{$status} {$count} ឯកសារ";
                    })
                    ->badge()
                    ->color(fn (Document $record): string => $record->hasValidFiles() ? 'success' : 'warning'),

                Tables\Columns\TextColumn::make('description')
                    ->label('ការពិពណ៌នា')
                    ->limit(30)
                    ->wrap()
                    ->tooltip(function (Tables\Columns\TextColumn $column): ?string {
                        $state = $column->getState();
                        if (strlen($state) <= 30) {
                            return null;
                        }
                        return $state;
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('បង្កើតនៅ')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->since()
                    ->color('gray'),
            ])
            ->filters([
                Filter::make('date_range')
                    ->label('តម្រងតាមកាលបរិច្ឆេទ')
                    ->form([
                        Grid::make(2)
                            ->schema([
                                Forms\Components\DatePicker::make('date_from')
                                    ->label('ចាប់ពីថ្ងៃទី')
                                    ->placeholder('ឧ.07/06/2025')
                                    ->native(false)
                                    ->displayFormat('d/m/Y'),
                                Forms\Components\DatePicker::make('date_to')
                                    ->label('រហូតដល់ថ្ងៃទី')
                                    ->native(false)
                                    ->placeholder('ឧ.08/06/2025')
                                    ->displayFormat('d/m/Y'),
                            ]),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['date_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '>=', $date),
                            )
                            ->when(
                                $data['date_to'],
                                fn (Builder $query, $date): Builder => $query->whereDate('date', '<=', $date),
                            );
                    }),

                SelectFilter::make('type')
                    ->label('ប្រភេទឯកសារ')
                    ->options([
                        'លិខិតចេញ' => 'លិខិតចេញ',
                        'លិខិតចូល' => 'លិខិតចូល',
                    ])
                    ->native(false),

                Filter::make('number_search')
                    ->label('ស្វែងរកលេខឯកសារ')
                    ->form([
                        Forms\Components\TextInput::make('number_search')
                            ->label('ស្វែងរកឯកសារ')
                            ->placeholder('បញ្ចូលលេខរាង ឬអត្តលេខ...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['number_search'],
                            function (Builder $query, $search): Builder {
                                return $query->where(function ($q) use ($search) {
                                    $q->where('number', 'like', "%{$search}%")
                                        ->orWhere('second_number', 'like', "%{$search}%");
                                });
                            }
                        );
                    }),

                Filter::make('source_file')
                    ->label('ប្រភពឯកសារ')
                    ->form([
                        Forms\Components\TextInput::make('source_file')
                            ->label('ស្វែងរកប្រភពឯកសារ')
                            ->placeholder('បញ្ចូលឈ្មោះប្រភពឯកសារ...'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['source_file'],
                            fn (Builder $query, $source): Builder => $query->where('source_file', 'like', "%{$source}%"),
                        );
                    }),

                // FIXED: Using TernaryFilter for better compatibility
                TernaryFilter::make('duplicate_numbers')
                    ->label('លេខឯកសារដូចគ្នា')
                    ->placeholder('ទាំងអស់')
                    ->trueLabel('មានលេខដូចគ្នា')
                    ->falseLabel('លេខតែមួយ')
                    ->queries(
                        true: fn (Builder $query) => $query->whereIn('number', function ($subQuery) {
                            $subQuery->select('number')
                                ->from('documents')
                                ->groupBy('number')
                                ->havingRaw('COUNT(*) > 1');
                        }),
                        false: fn (Builder $query) => $query->whereNotIn('number', function ($subQuery) {
                            $subQuery->select('number')
                                ->from('documents')
                                ->groupBy('number')
                                ->havingRaw('COUNT(*) > 1');
                        }),
                        blank: fn (Builder $query) => $query, // Show all
                    ),
            ])
            ->filtersLayout(FiltersLayout::AboveContent)
            ->filtersFormColumns(4)
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make()
                        ->label('មើលឯកសារ')
                        ->color('info')
                        ->modalContent(fn (Document $record) => view('filament.document-viewer-simple', ['document' => $record]))
                        ->modalWidth('7xl')
                        ->modalHeading(function (Document $record) {
                            $heading = 'ឯកសារលេខ: ' . $record->number;
                            if ($record->second_number) {
                                $heading .= ' / ' . $record->second_number;
                            }
                            $heading .= ' (ឆ្នាំ ' . $record->date->year . ' - ' . $record->type . ')';
                            return $heading;
                        }),

                    Tables\Actions\Action::make('download')
                        ->label('ទាញយក')
                        ->color('success')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->visible(fn (Document $record) => $record->hasValidFiles())
                        ->action(function (Document $record) {
                            try {
                                if (count($record->files) === 1) {
                                    $file = $record->files[0];
                                    if (Storage::disk('public')->exists($file)) {
                                        $customFileName = $record->generateDownloadFileName($file);
                                        return Storage::disk('public')->download($file, $customFileName);
                                    }
                                    throw new \Exception('File not found');
                                }
                                return $record->downloadAllFilesAsZip();
                            } catch (\Exception $e) {
                                Notification::make()
                                    ->title('កំហុសក្នុងការទាញយក')
                                    ->body('មិនអាចទាញយកឯកសារបានទេ: ' . $e->getMessage())
                                    ->danger()
                                    ->send();
                            }
                        }),

                    Tables\Actions\Action::make('view_duplicates')
                        ->label('មើលឯកសារដូចគ្នា')
                        ->color('warning')
                        ->icon('heroicon-o-document-duplicate')
                        ->visible(function (Document $record) {
                            return Document::getDocumentsWithSameNumber($record->number, $record->id)->count() > 0;
                        })
                        ->modalContent(function (Document $record) {
                            $duplicates = Document::getDocumentsWithSameNumber($record->number, $record->id);
                            return view('filament.document-duplicates', [
                                'current' => $record,
                                'duplicates' => $duplicates
                            ]);
                        })
                        ->modalWidth('4xl')
                        ->modalHeading(fn (Document $record) => 'ឯកសារដែលមានលេខ: ' . $record->number),

                    Tables\Actions\EditAction::make()
                        ->label('កែប្រែ')
                        ->color('warning')
                        ->visible(fn () => auth()->user()->isAdmin()),

                    Tables\Actions\DeleteAction::make()
                        ->label('លុប')
                        ->color('danger')
                        ->visible(fn () => auth()->user()->isAdmin())
                        ->requiresConfirmation()
                        ->modalHeading('លុបឯកសារ')
                        ->modalDescription('តើអ្នកពិតជាចង់លុបឯកសារនេះមែនទេ? ការលុបនេះមិនអាចត្រឡប់វិញបានទេ។')
                        ->modalSubmitActionLabel('បាទ/ចាស លុប')
                        ->modalCancelActionLabel('បោះបង់'),
                ])
                    ->label('សកម្មភាព')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->size('sm')
                    ->color('gray'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->label('លុបជាច្រើន')
                        ->visible(fn () => auth()->user()->isAdmin())
                        ->requiresConfirmation()
                        ->modalHeading('លុបឯកសារជាច្រើន')
                        ->modalDescription('តើអ្នកពិតជាចង់លុបឯកសារដែលបានជ្រើសរើសទាំងអស់នេះមែនទេ?')
                        ->modalSubmitActionLabel('បាទ/ចាស លុបទាំងអស់')
                        ->modalCancelActionLabel('បោះបង់'),
                ]),
            ])
            ->defaultSort('date', 'desc')
            ->striped()
            ->paginated([10, 25, 50, 100])
            ->emptyStateHeading('មិនមានឯកសារទេ')
            ->emptyStateDescription('សូមចុចប៊ូតុង "បង្កើតឯកសារថ្មី" ដើម្បីបន្ថែមឯកសារដំបូង')
            ->emptyStateIcon('heroicon-o-document-plus')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('បង្កើតឯកសារថ្មី')
                    ->visible(fn () => auth()->user()->isAdmin()),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocument::route('/create'),
            'edit' => Pages\EditDocument::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return static::getModel()::count() > 10 ? 'warning' : 'primary';
    }
}

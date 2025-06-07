<?php

namespace App\Filament\Widgets;

use App\Models\Document;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class RecentDocumentsWidget extends BaseWidget
{
    protected static ?string $heading = 'ឯកសារថ្មីៗ';

    protected int | string | array $columnSpan = 2;

    protected static ?string $pollingInterval = '30s';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Document::query()
                    ->latest()
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('type')
                    ->label('ប្រភេទ')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'លិខិតចេញ' => 'info',
                        'លិខិតចូល' => 'success',
                        default => 'gray',
                    }),

                Tables\Columns\TextColumn::make('number')
                    ->label('លេខឯកសារ')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('source_file')
                    ->label('ប្រភព')
                    ->limit(30)
                    ->wrap(),

                Tables\Columns\TextColumn::make('date')
                    ->label('កាលបរិច្ឆេទ')
                    ->date('d/m/Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('បង្កើត')
                    ->since()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('មើល')
                    ->icon('heroicon-m-eye')
                    ->url(fn (Document $record): string => route('filament.admin.resources.documents.edit', $record))
                    ->openUrlInNewTab(),
            ])
            ->paginated(false);
    }
}

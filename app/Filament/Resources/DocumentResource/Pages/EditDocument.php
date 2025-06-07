<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\Document;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;

class EditDocument extends EditRecord
{
    protected static string $resource = DocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn () => auth()->user()->isAdmin()),
        ];
    }

    protected function beforeSave(): void
    {
        $data = $this->data;

        // Check for duplicate number in same year AND same type (excluding current record)
        if (isset($data['number']) && isset($data['date']) && isset($data['type'])) {
            if (Document::isDuplicateNumberInSameYearAndType($data['number'], $data['date'], $data['type'], $this->record->id)) {
                $message = Document::getDuplicateMessage($data['number'], $data['date'], $data['type']);

                Notification::make()
                    ->title('❌ មិនអាចកែប្រែឯកសារបានទេ')
                    ->body($message)
                    ->danger()
                    ->persistent()
                    ->send();

                $this->halt();
            }
        }
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'ឯកសារត្រូវបានកែប្រែដោយជោគជ័យ! ✅';
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Log the edit for Darachhat
        \Log::info('Document updated by Darachhat', [
            'id' => $this->record->id,
            'number' => $data['number'],
            'date' => $data['date'],
            'type' => $data['type'],
            'user' => 'Darachhat',
            'timestamp' => '2025-06-07 13:58:57'
        ]);

        return $data;
    }
}

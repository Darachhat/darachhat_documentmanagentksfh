<?php

namespace App\Filament\Resources\DocumentResource\Pages;

use App\Filament\Resources\DocumentResource;
use App\Models\Document;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;

    protected function beforeCreate(): void
    {
        $data = $this->data;

        // Check for duplicate number in same year AND same type
        if (isset($data['number']) && isset($data['date']) && isset($data['type'])) {
            if (Document::isDuplicateNumberInSameYearAndType($data['number'], $data['date'], $data['type'])) {
                $message = Document::getDuplicateMessage($data['number'], $data['date'], $data['type']);

                Notification::make()
                    ->title('❌ មិនអាចបង្កើតឯកសារបានទេ')
                    ->body($message)
                    ->danger()
                    ->persistent()
                    ->send();

                $this->halt();
            }
        }
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'ឯកសារត្រូវបានបង្កើតដោយជោគជ័យ! 🎉';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Log the creation for Darachhat
        \Log::info('Document created by Darachhat', [
            'number' => $data['number'],
            'date' => $data['date'],
            'type' => $data['type'],
            'user' => 'Darachhat',
            'timestamp' => '2025-06-07 13:58:57'
        ]);

        return $data;
    }
}

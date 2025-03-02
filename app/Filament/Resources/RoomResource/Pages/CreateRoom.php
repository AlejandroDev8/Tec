<?php

namespace App\Filament\Resources\RoomResource\Pages;

use Filament\Actions;
use App\Filament\Resources\RoomResource;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateRoom extends CreateRecord
{
    protected static string $resource = RoomResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Sala creada')
            ->body('La habitación ha sido creada exitosamente.');
    }
}

<?php

namespace App\Filament\Resources\ReservationResource\Pages;

use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ReservationResource;

class CreateReservation extends CreateRecord
{
    protected static string $resource = ReservationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Reservación Creada')
            ->body('La reservación ha sido creada exitosamente.');
    }
}

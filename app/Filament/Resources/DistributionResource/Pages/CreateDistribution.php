<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateDistribution extends CreateRecord
{
    protected static string $resource = DistributionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Distribución de sillas creada')
            ->body('La distribución de sillas ha sido creada exitosamente.');
    }
}

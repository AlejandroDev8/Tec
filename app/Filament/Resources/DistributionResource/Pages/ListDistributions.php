<?php

namespace App\Filament\Resources\DistributionResource\Pages;

use App\Filament\Resources\DistributionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDistributions extends ListRecords
{
    protected static string $resource = DistributionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->color('warning')
                ->icon('heroicon-o-plus-circle'),

            Actions\Action::make('goHome')
                ->label('Ir al escritorio')
                ->icon('heroicon-o-home')
                ->url('/admin'),
        ];
    }
}

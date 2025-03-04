<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

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

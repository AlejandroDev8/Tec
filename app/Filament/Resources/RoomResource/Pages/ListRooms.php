<?php

namespace App\Filament\Resources\RoomResource\Pages;

use App\Filament\Resources\RoomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRooms extends ListRecords
{
    protected static string $resource = RoomResource::class;

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

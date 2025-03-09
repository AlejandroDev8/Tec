<?php

namespace App\Filament\Widgets;

use App\Models\Reservation;
use Filament\Actions\Action;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsReservations extends BaseWidget
{
    protected function getHeading(): ?string
    {
        return 'Reservaciones en el sistema';
    }

    protected function getDescription(): ?string
    {
        return 'Estadísticas de las reservaciones en el sistema';
    }

    protected function getApprovedReservations(Reservation $reservation)
    {
        return $reservation->where('status', 'aceptada')->count();
    }

    protected function getReejectedReservations(Reservation $reservation)
    {
        return $reservation->where('status', 'rechazada')->count();
    }

    protected function getPendingReservations(Reservation $reservation)
    {
        return $reservation->where('status', 'pendiente')->count();
    }

    protected function getStats(): array
    {
        return [
            Stat::make('Solicitudes aceptadas', $this->getApprovedReservations(new Reservation()))
                ->color('success')
                ->icon('heroicon-o-check-circle')
                ->description('Solicitudes de reservación aceptadas')
                ->descriptionIcon('heroicon-o-check-circle'),
            Stat::make('Solicitudes rechazadas', $this->getReejectedReservations(new Reservation()))
                ->color('danger')
                ->icon('heroicon-o-x-circle')
                ->description('Solicitudes de reservación rechazadas')
                ->descriptionIcon('heroicon-o-x-circle'),
            Stat::make('Solicitudes pendientes', $this->getPendingReservations(new Reservation()))
                ->color('warning')
                ->icon('heroicon-o-clock')
                ->description('Solicitudes de reservación pendientes')
                ->descriptionIcon('heroicon-o-clock'),
        ];
    }
}

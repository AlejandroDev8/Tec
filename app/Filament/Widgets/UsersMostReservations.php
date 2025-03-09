<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UsersMostReservations extends BaseWidget
{
    protected function getHeading(): ?string
    {
        return 'Usuarios con más reservaciones';
    }

    protected function getDescription(): ?string
    {
        return 'Usuarios con más reservaciones en el sistema de reservaciones';
    }

    protected function getTopUsers(int $limit = 5)
    {
        return User::withCount('reservations')
            ->has('reservations')
            ->orderByDesc('reservations_count')
            ->limit($limit)
            ->get();
    }

    protected function getStats(): array
    {
        $stats = [];

        foreach ($this->getTopUsers() as $user) {
            $stats[] = Stat::make(
                $user->name,
                $user->reservations_count . ' reservas'
            )
                ->description('Reservaciones totales')
                ->color(match (true) {
                    $user->reservations_count > 20 => 'danger',
                    $user->reservations_count > 10 => 'warning',
                    default => 'success'
                })
                ->icon('heroicon-o-user');
        }

        return $stats;
    }
}

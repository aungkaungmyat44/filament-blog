<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('All Users', User::count())
            ->description('All users in app')
            ->descriptionIcon('heroicon-o-users', IconPosition::Before)
            ->descriptionColor('info')
            ->chart([10, 20, 50, 30, 80, 100, 40])
            ->color('success')
        ];
    }
}

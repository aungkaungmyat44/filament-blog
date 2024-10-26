<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserWidget extends BaseWidget
{
    use InteractsWithPageFilters; 
    
    protected function getStats(): array
    {
        return [
            Stat::make('All Users', User::
            when(
                !empty($this->filters['startDate']), fn ($query) => $query->whereDate('created_at', '>', $this->filters['startDate'])
            )
            ->when(
                !empty($this->filters['endDate']), fn ($query) => $query->whereDate('created_at', '<', $this->filters['endDate'])
            )
            ->count()
            )
            ->description('All users in app')
            ->descriptionIcon('heroicon-o-users', IconPosition::Before)
            ->descriptionColor('info')
            ->chart([10, 20, 50, 30, 80, 100, 40])
            ->color('success')
        ];
    }
}

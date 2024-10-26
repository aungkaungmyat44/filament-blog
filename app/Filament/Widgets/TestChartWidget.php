<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TestChartWidget extends ChartWidget
{
    use InteractsWithPageFilters; // to responsive with search filters

    protected static ?string $heading = 'User Chart';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $startDate = $this->filters['startDate'] ?? null;
        $endDate = $this->filters['endDate'] ?? null;
        $name = $this->filters['name'] ?? null;

        $data = Trend::model(User::class)
                    ->between(
                        start: $startDate ? Carbon::parse($startDate) :now()->subMonth(6),
                        end: $endDate ? Carbon::parse($endDate) :now()
                    )
                    ->perMonth()
                    ->count();
        
        return [
            'datasets' => [
                [
                    'label' => 'Blog posts created',
                    'data' => $data->map(fn (TrendValue $value) => $value->aggregate),//[100, 300, 600],
                    'backgroundColor' => [
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)',
                        'rgb(255, 99, 132)',
                        'rgb(54, 162, 235)',
                        'rgb(255, 205, 86)'
                    ]
                ],
            ],
            'labels' => $data->map(fn (TrendValue $value) => $value->date),
        ];
    }

    protected function getType(): string
    {
        return 'doughnut'; // change chart type
    }
}

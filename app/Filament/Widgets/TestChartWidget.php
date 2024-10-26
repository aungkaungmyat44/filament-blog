<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class TestChartWidget extends ChartWidget
{
    protected static ?string $heading = 'User Chart';

    protected int | string | array $columnSpan = 1;

    protected function getData(): array
    {
        $data = Trend::model(User::class)
                    ->between(
                        start: now()->subWeek(6),
                        end: now(),
                    )
                    ->perWeek()
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

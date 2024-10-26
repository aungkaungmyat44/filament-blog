<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BasePage;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;

class Dashboard extends BasePage
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name'),
            DatePicker::make('startDate'),
            DatePicker::make('endDate'),
            Toggle::make('active')
        ]);
    }
}
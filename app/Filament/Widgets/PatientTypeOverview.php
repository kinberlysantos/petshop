<?php

namespace App\Filament\Widgets;

use App\Models\Patient;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Gatos', Patient::query()->where('type', 'gato')->count()),
            Stat::make('Cachorros', Patient::query()->where('type', 'cachorro')->count()),
            Stat::make('Coelhos', Patient::query()->where('type', 'coelho')->count()),
        ];
    }
}

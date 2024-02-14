<?php

namespace App\Filament\Widgets;


use App\Models\Student;
use App\Models\Topic;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(label:'Total estudiantes', value: Student::count())

            ->description('Cantidad de alumnos registrados en el sistema')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([7,3,4,5,6,8,18,29]),

            Stat::make(label:'Total disciplinas', value: Topic::count())

            ->description('Cantidad de disciplinas registradas en el sistema')
            ->descriptionIcon('heroicon-m-arrow-trending-up')
            ->color('success')
            ->chart([7,3,4,5,6,8,18,29]),
        ];
    }
}

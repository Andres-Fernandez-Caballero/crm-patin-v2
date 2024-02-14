<?php

namespace App\Filament\Widgets;

use App\Models\Student;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class DisciplinesChart extends ChartWidget
{
    protected static ?string $heading = 'Chart';

    protected function getData(): array
    {
        $data = $this->getStudentsMensual();

        return [
            'datasets'  => [
                [
                    'label' =>'Alumnos registrados.',
                    'data'=> $data['studentsMensual']
                ]
            ],
            'labels' =>$data['Meses']
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    private function getStudentsMensual(): array
    {
        $now = Carbon::now();
        $studentsMensual = [];
        
        $meses = collect(range(start: 1, end: 12))->map(function ($month) use ($now, &$studentsMensual) {
            $count = Student::whereMonth('created_at', Carbon::parse($now->month($month)->format('Y-m')))->count();
            $studentsMensual[] = $count;
            return $now->month($month)->format('M');
        })->toArray();

        return [
            'studentsMensual' => $studentsMensual,
            'Meses' => $meses
        ];
    }
}

<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Filament\Widgets\ChartWidget;
use Carbon\Carbon;

class DinerMensual extends ChartWidget
{
    protected static ?string $heading = 'Cantidad de dinero recaudado cada mes.';

    protected function getData(): array
    {
        $data = $this->getDineroMensual();

        return [
            'datasets'  => [
                [
                    'label' =>'Dinero recaudado por mes.',
                    'data'=> $data['dineroMensual']
                ]
            ],
            'labels' =>$data['Meses']
        ];
    }
    private function getDineroMensual(): array
    {
        $now = Carbon::now();
        $dineroMensual = [];
        
        $meses = collect(range(start: 1, end: 12))->map(function ($month) use ($now, &$dineroMensual) {
            $count = Payment::whereMonth('payment_date_open', Carbon::parse($now->month($month)->format('Y-m')))->sum('total_amount');
            $dineroMensual[] = $count;
            return $now->month($month)->format('M');
        })->toArray();

        return [
            'dineroMensual' => $dineroMensual,
            'Meses' => $meses
        ];
    }
    

    protected function getType(): string
    {
        return 'bar';
    }
}

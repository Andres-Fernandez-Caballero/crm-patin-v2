<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class MonthlyDetailWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make(
                
                label: 'Cuotas abonadas ',
                value: Payment::whereMonth('payment_date_open', Carbon::parse(Carbon::now()->month()->format('Y-m')))
                ->where('payment_date_paid', '!=', null)
                ->sum('total_amount')
                )
                ->color('warning')

                ->description(
                    'Cuotas totales $' . Payment::whereMonth('payment_date_open', Carbon::parse(Carbon::now()->month()->format('Y-m')))
                    // ->where('payment_date_paid', null)
                ->sum('total_amount')
                
            )
        ];
    }
}

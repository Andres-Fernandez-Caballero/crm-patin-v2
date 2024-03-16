<?php

namespace App\Filament\Widgets;

use App\Models\Payment;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Log;

class MonthlyDetailWidget extends BaseWidget
{
    protected function getStats(): array
    {
        Log::alert(Carbon::now()->month()->format('Y-m'));
        return [
            Stat::make(
                
                label: 'Dinero recaudado este mes ',
                value: Payment::whereMonth('payment_date_open', Carbon::now())

                ->sum('total_amount')
            ),


            Stat::make(
                label: 'Dinero recaudado este año',
                value: Payment::whereYear('payment_date_open', Carbon::now()->year)
                    ->sum('total_amount')
            )
        ];
    }
}

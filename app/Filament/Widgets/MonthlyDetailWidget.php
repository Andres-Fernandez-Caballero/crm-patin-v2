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
                
                label: 'Cuotas abonadas ',
                value: Payment::whereMonth('payment_date_open', Carbon::now())

                ->sum('total_amount')
                )
        ];
    }
}

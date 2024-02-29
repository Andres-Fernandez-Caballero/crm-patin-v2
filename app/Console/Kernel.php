<?php

namespace App\Console;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;


use function App\Jobs\resetStudentState;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $students = Student::all()->where('state', '!=', 'inactivo')->each(function (Student $student) {
                Log::info('estado estudiante', [$student]);
                $student->update(['state' => 'pago pendiente']);
            });


            Log::info('estudiantes reiniciados el ' . Carbon::now()->toISOString(), [$students]);
        })->everyTwoSeconds();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

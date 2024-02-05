<?php

namespace App\Console\Commands;

use App\Models\Student;
use App\Models\Ticket;
use Illuminate\Console\Command;

class CreateBillingPeriod extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-billing-period';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'for each student create a new ticket for the current month';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Student::chunk(200, function ($students) {
            foreach ($students as $student) {
                $ticketAux = Ticket::create([
                    'period_start' => now()->format('Y-m-01'),
                    'student_id' => $student->id,
                ]);

                $ticketAux->topics()->attach([1, 2, 3]);
            }
        });
    }
}

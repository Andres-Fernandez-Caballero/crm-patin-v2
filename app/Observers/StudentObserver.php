<?php

namespace App\Observers;

use App\Jobs\ProcessCreateTicket;
use App\Models\Student;
use App\Models\Ticket;

class StudentObserver
{
    /**
     * Handle the Student "saved" event.
     */
    public function saved(Student $student): void
    {

        $student->load(['topics']);
        dd($student->topics()->pluck('id')->toArray());
        //
    }
    /**
     * Handle the Student "created" event.
     */
    public function created(Student $student): void
    {
        


        /*
        $ticket = Ticket::create([
            'student_id' => $student->id,
            'period_start' => now()->format('Y-m-01'),
        ]);
        */
    }
    /**
     * Handle the Student "updated" event.
     */
    public function updated(Student $student): void
    {
        
    }

    /**
     * Handle the Student "deleted" event.
     */
    public function deleted(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "restored" event.
     */
    public function restored(Student $student): void
    {
        //
    }

    /**
     * Handle the Student "force deleted" event.
     */
    public function forceDeleted(Student $student): void
    {
        //
    }
}

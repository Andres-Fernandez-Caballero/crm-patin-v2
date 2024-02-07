<?php

namespace App\Observers;

use App\Jobs\ProcessCreateTicket;
use App\Models\Student;
use App\Models\Ticket;

class TicketObserver
{
    public $afterCommit = true;

    /**
     Handle the Ticket "saved" event.
    */
    public function saved(Ticket $ticket){
       
    }

    /**
     * Handle the Ticket "created" event.
     */
    public function created(Ticket $ticket): void
    {
        $student = Student::find($ticket->student_id);
        
        $topics = $student->topics->pluck('id')->toArray();
        
        Ticket::withoutEvents(function () use ($ticket, $topics) {
            $ticket->topics()->sync($topics);
            $ticket->save();
        });
    }

    /**
     * Handle the Ticket "updated" event.
     */
    public function updated(Ticket $ticket): void
    {
        $student = Student::find($ticket->student_id);
        $topics = $student->topics->pluck('id')->toArray();
        $ticket->topics()->sync($topics);
        $ticket->save();
    }

    /**
     * Handle the Ticket "deleted" event.
     */
    public function deleted(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "restored" event.
     */
    public function restored(Ticket $ticket): void
    {
        //
    }

    /**
     * Handle the Ticket "force deleted" event.
     */
    public function forceDeleted(Ticket $ticket): void
    {
        //
    }
}

<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Ticket;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessCreateTicket implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $studentId;
    private int $ticketId;
    /**
     * Create a new job instance.
     */
    public function __construct(int $studentId, int $ticketId)
    {
        $this->studentId = $studentId;
        $this->ticketId = $ticketId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $student = Student::findOrFail($this->studentId);
            $ticket = Ticket::findOrFail($this->ticketId);
            
            $topics = $student->topics()->pluck('id')->toArray;

            $ticket->topics()->sync($topics);
            $ticket->save();
       }catch(Exception  $e){
        dd('excepcion a controlar');
       }    
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateTicketJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private int $studentId;
    /**
     * Create a new job instance.
     */
    public function __construct(int $studenId)
    {
        $this->studentId = $studentId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try{
            $Student = Student::findOrFail($this->studentId);
            $student->load('topics');
            $topics = $student->topics()->pluck('id')->toArray();
            \Log::info('Se ha creado un nuevo ticket para el estudiante con id: ' . $this->studentId . ' y los temas son: ' . implode(',', $topics));
        
            $ticket = Ticket::create([
                'student_id' => $this->studentId,
                'period_start' => now()->format('Y-m-01'),
            ]);

            $ticket->topics()->attach($topics);
            $ticket->save();
        }catch(\Illuminate\Database\Eloquent\ModelNotFoundException $e){
            \Log::error('No se ha encontrado el estudiante con id: ' . $this->studentId);
        }
        catch(\Exception $e){
            \Log::error('fallo el JOB -> ' . $e->getMessage());
        }
    
    }
}

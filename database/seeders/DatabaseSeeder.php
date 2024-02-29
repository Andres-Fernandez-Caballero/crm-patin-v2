<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Payment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com', 
        ]);

        $this->call([
            TopicSeeder::class,
            //StudentSeeder::class,
        ]);

        Student::factory(5)
           ->has(Payment::factory()->count(random_int(2, 10)))
            ->create()
            ->each(function ($student) {
                $student->topics()->attach([1, 2, 3]);
        });

        // User::factory(1)->create();

        
    }
}

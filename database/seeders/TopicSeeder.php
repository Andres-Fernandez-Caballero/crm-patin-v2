<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $topics = [
            'Principiante' => 1000,
            'intermendio' => 1500,
            'avanzado' => 2000,
            ];

        foreach ($topics as $name => $price) {
            Topic::create([
                'name' => $name,
                'price' => $price,
            ]);
        }   
    }
}

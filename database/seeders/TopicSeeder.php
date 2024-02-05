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
            'Iniciación 1 x sem' => 1000,
            'Iniciación 2 x sem' => 1500,
            'C libre' => 2000,
            'B libre' => 2000,
            'A libre' => 2000,
            'C figuras' => 2000,
            'B figuras' => 2000,
            'A figuras' => 2000,
            'Particular 1 x sem' => 2000,
            'Particular 2 x sem' => 2000,
            'Particular 3 x sem' => 2000,
            'Particular 4 x sem' => 2000,
            'Particular 5 x sem' => 2000,
            'Libre C-B-A Febrero' => 2000,
            'Iniciación 2 x sem Febrero' => 2000,
            'Iniciación 1 x sem Febrero' => 2000,
            'Pack 4 x Febrero' => 2000,
            'Pack 8 x Febrero' => 2000,
            'Pack 12 x Febrero' => 2000,
            'Pack 16 x Febrero' => 2000,
            'Figuras A-B-C Febrero' => 2000,
            ];

        foreach ($topics as $name => $price) {
            Topic::create([
                'name' => $name,
                'price' => $price,
            ]);
        }   
    }
}

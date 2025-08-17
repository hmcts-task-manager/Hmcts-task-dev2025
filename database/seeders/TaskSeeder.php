<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tasks')->insert([
            [
                'title' => 'Buy groceries',
                'description' => 'Milk, eggs, bread',
                'status' => 'todo',
                'due_at' => Carbon::now()->addDays(1),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Finish Laravel project',
                'description' => 'Complete backend and frontend',
                'status' => 'in_progress',
                'due_at' => Carbon::now()->addDays(3),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Go to gym',
                'description' => null,
                'status' => 'done',
                'due_at' => Carbon::now()->subDay(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}

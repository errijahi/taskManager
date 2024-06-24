<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::table('projects')->insert([
            ['name' => 'Project1'],
            ['name' => 'Project2'],
        ]);

        DB::table('tasks')->insert([
            ['name' => 'Task1', 'priority' => 1, 'created_at' => now(), 'project_id' => 1],
            ['name' => 'Task2', 'priority' => 2, 'created_at' => now(), 'project_id' => 1],
            ['name' => 'Task3', 'priority' => 3, 'created_at' => now(), 'project_id' => 1],

            ['name' => 'Task1', 'priority' => 1, 'created_at' => now(), 'project_id' => 2],
            ['name' => 'Task2', 'priority' => 2, 'created_at' => now(), 'project_id' => 2],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $projects = DB::table('projects')->pluck('id');

        DB::table('tasks')->insert([
            [
                'project_id' => $projects[0],
                'name' => 'Task 1 for Alpha',
                'description' => 'Description for Task 1 in Project Alpha.',
                'status' => 'todo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_id' => $projects[0],
                'name' => 'Task 2 for Alpha',
                'description' => 'Description for Task 2 in Project Alpha.',
                'status' => 'in-progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_id' => $projects[1],
                'name' => 'Task 1 for Beta',
                'description' => 'Description for Task 1 in Project Beta.',
                'status' => 'done',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_id' => $projects[1],
                'name' => 'Task 2 for Beta',
                'description' => 'Description for Task 2 in Project Beta.',
                'status' => 'todo',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'project_id' => $projects[2],
                'name' => 'Task 1 for Gamma',
                'description' => 'Description for Task 1 in Project Gamma.',
                'status' => 'in-progress',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}

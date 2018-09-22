<?php

use Illuminate\Database\Seeder;
use App\Models\TaskComment;
use App\Models\TodoComment;
use App\Models\TaskUser;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //generates users
        factory('App\Models\User', 5)->create()->each(function($user_model){
            //generate lists
            factory('App\Models\Todo', 2)->create(['user_id' => $user_model->id])->each(function($todo_model) use($user_model){
                //add comments in list
                factory('App\Models\Comment', rand(0,2))->create(['user_id' => $user_model->id, 'todo_id' => $todo_model->id]);
            });

            //generate tasks in list
            factory('App\Models\Task', rand(0,5))->create()->each(function($task_model) use($user_model){
                //add comments in tasks
                factory('App\Models\Comment', rand(0,2))->create(['user_id' => $user_model->id, 'task_id' => $task_model->id]);
                //creates relation between tasks and users
                TaskUser::create(['user_id' => $user_model->id, 'task_id' => $task_model->id]);
            });
        });
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('todos', function(Blueprint $table){
            $table->foreign('user_id')->references('id')
                ->on('users');
        });

        Schema::table('task_users', function(Blueprint $table){
            $table->foreign('task_id')->references('id')
                ->on('tasks');

            $table->foreign('user_id')->references('id')
                ->on('users');
        });

        Schema::table('comments', function(Blueprint $table){
            $table->foreign('task_id')->references('id')
                ->on('tasks');

            $table->foreign('user_id')->references('id')
                ->on('users');

            $table->foreign('todo_id')->references('id')
                ->on('todos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('todos', function(Blueprint $table){
            $table->dropForeign('todos_user_id_foreign');
        });

        Schema::table('task_users', function(Blueprint $table){
            $table->dropForeign('task_users_task_id_foreign');
            $table->dropForeign('task_users_user_id_foreign');
        });

        Schema::table('todo_comments', function(Blueprint $table){
            $table->dropForeign('comments_todo_id_foreign');
            $table->dropForeign('comments_task_id_foreign');
            $table->dropForeign('comments_user_id_foreign');
        });
    }
}

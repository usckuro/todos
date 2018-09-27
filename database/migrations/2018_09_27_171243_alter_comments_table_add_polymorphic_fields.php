<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterCommentsTableAddPolymorphicFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function(Blueprint $table){
            $table->unsignedInteger('commentable_id')->after('user_id')->nullable();
            $table->string('commentable_type',120)->nullable()->after('comment');
        });

        Schema::table('comments', function(Blueprint $table){
            $table->dropForeign('comments_task_id_foreign');
            $table->dropColumn('task_id');
        });

        Schema::table('comments', function(Blueprint $table){
            $table->dropForeign('comments_todo_id_foreign');
            $table->dropColumn('todo_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function(Blueprint $table){
            $table->dropColumn('commentable_type');
        });

        Schema::table('comments', function(Blueprint $table){
            $table->dropColumn('commentable_id');
        });

        Schema::table('comments', function(Blueprint $table){
            $table->unsignedInteger('task_id')->nullable();

            $table->foreign('task_id')->references('id')
                ->on('tasks');
        });

        Schema::table('comments', function(Blueprint $table){
            $table->unsignedInteger('todo_id')->nullable();

            $table->foreign('todo_id')->references('id')
                ->on('todos');
        });
    }
}

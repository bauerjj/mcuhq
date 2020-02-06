<?php

use Hazzard\Comments\Comment;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('comments.table_names.votes'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('comment_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->enum('type', ['up', 'down'])->default('up');
            $table->timestamps();

            $table->foreign('comment_id')
                    ->references('id')
                    ->on(config('comments.table_names.comments'))
                    ->onDelete('cascade');

            $table->foreign('user_id')
                    ->references('id')
                    ->on((new Comment::$userModel)->getTable())
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('comments.table_names.votes'));
    }
}

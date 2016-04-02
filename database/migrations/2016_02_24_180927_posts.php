<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Posts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // blog table
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('author_id')->unsigned()->default(0);
            $table->foreign('author_id')
              ->references('id')->on('users')
              ->onDelete('cascade');
            $table->string('title'); // doesn't have to be unique anymore
            $table->string('description');
            $table->string('more_info_link'); // i.e github/bitbucket link, blog url, etc
            $table->text('body'); // raw markdown user input
            $table->text('body_html'); // markdown converted into html so as to not convert everytime
            $table->string('slug')->unique();
            $table->string('main_image')->unique();
            $table->string('source_file')->unique();
            $table->boolean('active');
            $table->integer('view_count')->default(0);

            $table->integer('mcu_id')->default(0);
            $table->foreign('mcu_id')
                ->references('id')->on('mcus')
                ->onDelete('cascade');
            $table->integer('compiler_id')->default(0);
            $table->foreign('compiler_id')
                ->references('id')->on('mcu_compilers')
                ->onDelete('cascade');

            $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop the table
        Schema::drop('posts');
    }
}

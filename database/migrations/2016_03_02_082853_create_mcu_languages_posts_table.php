<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcuLanguagesPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_languages_posts', function (Blueprint $table) {
            $table->integer('language_id')->unsigned()->default(0);
            $table->foreign('language_id')
                ->references('id')->on('mcu_languages')
                ->onDelete('cascade');
            $table->integer('post_id')->unsigned()->default(0);
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');
            $table->timestamps();
            $table->primary(array('language_id','post_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mcu_languages_posts');
    }
}

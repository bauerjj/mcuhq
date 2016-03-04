<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcuCompilersPosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_compilers_posts', function (Blueprint $table) {
            $table->integer('compiler_id')->unsigned()->default(0);
            $table->foreign('compiler_id')
                ->references('id')->on('mcu_compilers')
                ->onDelete('cascade');
            $table->integer('post_id')->unsigned()->default(0);
            $table->foreign('post_id')
                ->references('id')->on('posts')
                ->onDelete('cascade');
            $table->timestamps();
            $table->primary(array('compiler_id','post_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mcu_compilers_posts');
    }
}

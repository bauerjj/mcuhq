<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBlogCategoriesPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories_blog_pivot', function (Blueprint $table) {
            $table->integer('blog_id')->unsigned()->default(0);
            $table->foreign('blog_id')
                ->references('id')->on('blog')
                ->onDelete('cascade');
            $table->integer('category_id')->unsigned()->default(0);
            $table->foreign('category_id')
                ->references('id')->on('categories_blog')
                ->onDelete('cascade');
            $table->timestamps();
            $table->primary(array('blog_id','category_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categories_blog_pivot');
    }
}

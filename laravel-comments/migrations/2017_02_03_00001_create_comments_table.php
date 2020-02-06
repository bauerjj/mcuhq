<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableName = config('comments.table_names.comments');

        Schema::create($tableName, function (Blueprint $table) use ($tableName) {
            $table->increments('id');
            $table->unsignedInteger('commentable_id')->nullable();
            $table->string('commentable_type')->nullable();
            $table->index(['commentable_id', 'commentable_type']);
            $table->string('page_id')->index()->nullable();
            $table->integer('user_id')->unsigned()->nullable();
            $table->string('author_name')->nullable();
            $table->string('author_email')->nullable();
            $table->string('author_url')->nullable();
            $table->string('author_ip')->nullable();
            $table->string('user_agent')->nullable();
            $table->text('content');
            $table->string('permalink')->nullable();
            $table->integer('upvotes')->default(0);
            $table->integer('downvotes')->default(0);
            $table->enum('status', ['approved', 'pending', 'spam', 'trash'])->default('approved');
            $table->integer('root_id')->unsigned()->index()->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->timestamps();

            $table->foreign('root_id')
                    ->references('id')
                    ->on($tableName)
                    ->onDelete('cascade');

            $table->foreign('parent_id')
                    ->references('id')
                    ->on($tableName)
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
        Schema::dropIfExists(config('comments.table_names.comments'));
    }
}

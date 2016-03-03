<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug', 255)->index();
            $table->integer('vendor_id')->unsigned()->default(0);
            $table->foreign('vendor_id')
                ->references('id')->on('mcu_vendors')
                ->onDelete('cascade');
            $table->integer('arch_id')->unsigned()->default(0);
            $table->foreign('arch_id')
                ->references('id')->on('mcu_archs')
                ->onDelete('cascade');
            $table->integer('count')->unsigned()->default(0);
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
        Schema::drop('mcus');

    }
}

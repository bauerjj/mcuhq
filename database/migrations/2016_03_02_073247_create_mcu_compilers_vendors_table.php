<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMcuCompilersVendorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mcu_compilers_vendors', function (Blueprint $table) {
            $table->integer('compiler_id')->unsigned()->default(0);
            $table->foreign('compiler_id')
                ->references('id')->on('mcu_compilers')
                ->onDelete('cascade');
            $table->integer('vendor_id')->unsigned()->default(0);
            $table->foreign('vendor_id')
                ->references('id')->on('mcu_vendors')
                ->onDelete('cascade');
            $table->timestamps();
            $table->primary(array('compiler_id','vendor_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('mcu_compilers_vendors');
    }
}

<?php

use Illuminate\Database\Seeder;

class mcuCompilersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = \Carbon\Carbon::now()->toDateTimeString();
        $data = array(
            //mchp
            array('name'=>'xc8','created_at'=> $now,'updated_at' => $now),
            array('name'=>'xc16','created_at'=> $now,'updated_at' => $now),
            array('name'=>'xc32','created_at'=> $now,'updated_at' => $now),
            array('name'=>'ccs','created_at'=> $now,'updated_at' => $now),

            //atmel
            array('name'=>'avr studio 5','created_at'=> $now,'updated_at' => $now),
            array('name'=>'avr studio 4','created_at'=> $now,'updated_at' => $now),
            array('name'=>'iar embedded workbench','created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcu_compilers')->insert($data);
    }
}

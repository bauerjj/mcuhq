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
            array('name'=>'XC8','slug'=> 'xc8','created_at'=> $now,'updated_at' => $now),
            array('name'=>'XC16','slug'=> 'xc16','created_at'=> $now,'updated_at' => $now),
            array('name'=>'XC32','slug'=> 'xc32','created_at'=> $now,'updated_at' => $now),
            array('name'=>'CCS','slug'=> 'ccs','created_at'=> $now,'updated_at' => $now),

            //atmel
            array('name'=>'AVR Studio 5','slug'=> 'avr-studio-5','created_at'=> $now,'updated_at' => $now),
            array('name'=>'AVR Studio 4','slug'=> 'avr-studio-4','created_at'=> $now,'updated_at' => $now),
            array('name'=>'IAR Embedded Workbench','slug'=> 'iar-embedded-workbench','created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcu_compilers')->insert($data);
    }
}

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
            array('name'=>'XC8','slug'=> 'xc8','vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'XC16','slug'=> 'xc16','vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'XC32','slug'=> 'xc32','vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'CCS','slug'=> 'ccs','vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),

            //atmel
            array('name'=>'AVR Studio 5','slug'=> 'avr-studio-5','vendor_id'=> 2, 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'AVR Studio 4','slug'=> 'avr-studio-4','vendor_id'=> 2, 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'IAR Embedded Workbench','slug'=> 'iar-embedded-workbench','vendor_id'=> 2, 'created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcu_compilers')->insert($data);
    }
}

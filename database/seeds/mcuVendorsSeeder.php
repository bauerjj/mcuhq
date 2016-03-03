<?php

use Illuminate\Database\Seeder;

class mcuVendorsSeeder extends Seeder
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
            array('name'=>'Microchip','slug'=>'microchip', 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'Cypress','slug'=>'cypress', 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'Atmel','slug'=>'atmel', 'created_at'=> $now,'updated_at' => $now),
        );

        DB::table('mcu_vendors')->insert($data);

    }
}

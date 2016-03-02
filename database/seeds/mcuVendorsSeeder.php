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
            array('name'=>'microchip','created_at'=> $now,'updated_at' => $now),
            array('name'=>'cypress','created_at'=> $now,'updated_at' => $now),
            array('name'=>'atmel','created_at'=> $now,'updated_at' => $now),
        );

        DB::table('mcu_vendors')->insert($data);

    }
}

<?php

use Illuminate\Database\Seeder;

class mcuArchsSeeder extends Seeder
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
            array('name'=>'8bit','created_at'=> $now,'updated_at' => $now),
            array('name'=>'16bit','created_at'=> $now,'updated_at' => $now),
            array('name'=>'24bit','created_at'=> $now,'updated_at' => $now),
            array('name'=>'32bit','created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcu_archs')->insert($data);
    }
}

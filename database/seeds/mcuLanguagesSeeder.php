<?php

use Illuminate\Database\Seeder;

class mcuLanguagesSeeder extends Seeder
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
            array('name'=>'c','created_at'=> $now,'updated_at' => $now),
            array('name'=>'c++','created_at'=> $now,'updated_at' => $now),
            array('name'=>'asembler','created_at'=> $now,'updated_at' => $now),
            array('name'=>'labview','created_at'=> $now,'updated_at' => $now),
            array('name'=>'rust','created_at'=> $now,'updated_at' => $now),
        );

        DB::table('mcu_languages')->insert($data);
    }
}

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
            array('name'=>'C','slug'=>'c','created_at'=> $now,'updated_at' => $now),
            array('name'=>'C++','slug'=>'c++','created_at'=> $now,'updated_at' => $now),
            array('name'=>'Assembler','slug'=>'asembler','created_at'=> $now,'updated_at' => $now),
            array('name'=>'LabVIEW','slug'=>'labview','created_at'=> $now,'updated_at' => $now),
            array('name'=>'RUST','slug'=>'rust','created_at'=> $now,'updated_at' => $now),
        );

        DB::table('mcu_languages')->insert($data);
    }
}

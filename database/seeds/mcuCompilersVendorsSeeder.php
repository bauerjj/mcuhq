<?php

use Illuminate\Database\Seeder;

class mcuCompilersVendorsSeeder extends Seeder
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
            array('compiler_id'=>1,'vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),
            array('compiler_id'=>2,'vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),
            array('compiler_id'=>3,'vendor_id'=> 1, 'created_at'=> $now,'updated_at' => $now),

            //gcc
            array('compiler_id'=>4,'vendor_id'=> 2, 'created_at'=> $now,'updated_at' => $now),
            array('compiler_id'=>4,'vendor_id'=> 3, 'created_at'=> $now,'updated_at' => $now),


            //atmel
            array('compiler_id'=>5,'vendor_id'=> 3, 'created_at'=> $now,'updated_at' => $now),
            array('compiler_id'=>6,'vendor_id'=> 3, 'created_at'=> $now,'updated_at' => $now),
            array('compiler_id'=>7,'vendor_id'=> 3, 'created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcu_compilers_vendors')->insert($data);
    }
}

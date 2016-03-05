<?php

use Illuminate\Database\Seeder;

class mcuMcusSeeder extends Seeder
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
            array('name'=>'PIC10','slug'=>'pic10', 'vendor_id' => 1, 'arch_id' => 1 , 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'PIC16','slug'=>'pic16', 'vendor_id' => 1, 'arch_id' => 1 , 'created_at'=> $now,'updated_at' => $now),
            array('name'=>'AVR','slug'=>'avr', 'vendor_id' => 2, 'arch_id' => 1 , 'created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcus')->insert($data);

    }
}

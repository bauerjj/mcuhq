<?php

use Illuminate\Database\Seeder;

class mcuCompilersPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('compiler_id'=>'1','post_id'=> '7'),
            array('compiler_id'=>'2','post_id'=> '6'),

        );

        DB::table('mcu_compilers_posts')->insert($data);
    }
}

<?php

use Illuminate\Database\Seeder;

class mcuLanguagesPostsSeeder extends Seeder
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

            // ENSURE POST_ID of 5 and 6 exists!!!
            array('language_id'=>1,'post_id'=> 5, 'created_at'=> $now,'updated_at' => $now),
            array('language_id'=>2,'post_id'=> 5, 'created_at'=> $now,'updated_at' => $now),
            array('language_id'=>1,'post_id'=> 6, 'created_at'=> $now,'updated_at' => $now),

        );

        DB::table('mcu_languages_posts')->insert($data);
    }
}

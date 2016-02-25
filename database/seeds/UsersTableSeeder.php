<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create();

        DB::table('users')->delete();
        DB::table('users')->insert([
            'name' => 'Chris Sevilleja',
            'email' => 'chris@scotch.io',
            'role' => 'author',
            'password' => Hash::make('awesome'),
            'created_at' => $faker->dateTime(),
            'updated_at' => $faker->dateTime(),
        ]);
    }

}
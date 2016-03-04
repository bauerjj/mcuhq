<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //$this->call(UsersTableSeeder::class);
        $this->call(mcuArchsSeeder::class);
        $this->call(mcuVendorsSeeder::class);
        $this->call(mcuCompilersSeeder::class);
        $this->call(mcuCompilersVendorsSeeder::class);

        $this->call(mcuLanguagesSeeder::class);
        $this->call(mcuLanguagesPostsSeeder::class);
        $this->call(mcuCompilersPostsSeeder::class);

    }
}

<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call('ClienteSeeder');
	   	$this->call('VehiculoSeeder');
		$this->call('UserSeeder');
        // $this->call(UserSeeder::class);
    }
}

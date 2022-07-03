<?php

namespace Database\Seeders;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run() {
		$Admin = Admin::create([
			'entered_by_id' => '1',
			'name' => 'Gautam Mer',
			'email' => 'mergautam9@gmail.com',
			'password' => password_hash('Gautam2141', PASSWORD_BCRYPT, ['cost' => 10]),
			'phone' => '8320540592',
			'address' => 'India',
		]);
		$Admin->attachRoles(['admin','author']);
		$Admin->setting()->create([]);

       

	}
}

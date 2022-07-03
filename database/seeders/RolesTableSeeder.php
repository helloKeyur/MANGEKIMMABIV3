<?php

namespace Database\Seeders;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run() {
		Role::create([ // 'name', 'display_name', 'description'
			'name' => 'admin',
			'display_name' => 'Administrator',
			'description' => 'All access Administrator, Highest Access',
		]);
		// Role::create([ // 'name', 'display_name', 'description'
		// 	'name' => 'editor',
		// 	'display_name' => 'Editor',
		// 	'description' => 'Roles for Administrator, Higher Access',
		// ]);

		Role::create([ // 'name', 'display_name', 'description'
			'name' => 'author',
			'display_name' => 'Author',
			'description' => 'Roles for  Author, Higher Access',
		]);



		Role::create([ // 'name', 'display_name', 'description'
			'name' => 'technician',
			'display_name' => 'Technician',
			'description' => 'Roles for  Technician, Higher Access',
		]);

		
}


}




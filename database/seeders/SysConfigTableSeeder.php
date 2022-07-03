<?php

namespace Database\Seeders;

use App\Models\SysConfig;

use Illuminate\Database\Seeder;

class SysConfigTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SysConfig::create([]);
    }
}

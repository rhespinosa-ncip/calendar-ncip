<?php

namespace Database\Seeders;

use App\Models\Department as ModelsDepartment;
use Illuminate\Database\Seeder;

class Department extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelsDepartment::create(['name' => 'admin','hexa_color' => '#FF5733']);
    }
}

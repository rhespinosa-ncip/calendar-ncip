<?php

namespace Database\Seeders;

use App\Models\Department as ModelsDepartment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Department extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $divisions = array(
            'admin',
            'Recognition Division',
            'Resource Mgmt. Division',
            'Policy & Planning Division',
            'Information & Research Division',
            'Educ. & Culture Development Division',
            'Health Development Division',
            'Socio-Economic Development Division',
            'Special Concerns Division',
            'Empowerment Division',
            'Human Rights Division',
            'Accounting Division',
            'Budget Division',
            'Human Resource Mgmt. Division',
            'General Services Division',
            'Public Assistance Division',
            'Litigation & Adjudication Div',
            'Project Management Monitoring and Evaluation',
        );

        foreach($divisions as $division){
            $this->insertFunction($division);
        }
    }

    public function insertFunction($division){
        ModelsDepartment::create([
            'name' => $division,
            'hexa_color' => '#'.substr(md5(rand()), 0, 6)
        ]);
    }
}

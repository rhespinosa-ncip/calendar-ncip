<?php

namespace Database\Seeders;

use App\Models\BureauDivision as ModelsBureauDivision;
use Illuminate\Database\Seeder;

class BureauDivision extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bureauDivision = array(
            '1'=> array('2', '3'),
            '2'=> array('4', '5'),
            '3'=> array('6', '7'),
            '4'=> array('8', '9'),
            '5'=> array('10', '11'),
            '6'=> array('12', '13', '14', '15'),
            '7'=> array('16', '17'),
            '8'=> array('18'),
        );

        foreach($bureauDivision as $key => $value){
            foreach($value as $division){
                $this->insertFunction(
                    $key,
                    $division,
                );
            }
        }
    }

    public function insertFunction($bureau, $department){
        ModelsBureauDivision::create([
            'bureau_id' => $bureau,
            'department_id' => $department
        ]);
    }
}

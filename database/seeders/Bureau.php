<?php

namespace Database\Seeders;

use App\Models\Bureau as ModelsBureau;
use Illuminate\Database\Seeder;

class Bureau extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){
        $bureaus = array(
            'Ancestral Domains Office',
            'Office on Policy, Planning and Research',
            'Office on Education, Culture & Health',
            'Office on SocioEco. Services & Special Concerns',
            'Office of Empowerment & Human Rights',
            'Finance and Administrative Office',
            'Legal Affairs Office',
            'Office of the Chairperson',
        );

        foreach($bureaus as $bureau){
            $this->insertFunction($bureau);
        }
    }

    public function insertFunction($bureau){
        ModelsBureau::create([
            'name' => $bureau,
            'hexa_color' => '#'.substr(md5(rand()), 0, 6)
        ]);
    }
}

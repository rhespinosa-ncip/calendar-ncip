<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInformation extends Model
{
    use HasFactory;

    protected $table = 'personal_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name_extension',
        'date_of_birth',
        'place_of_birth',
        'sex',
        'civil_status',
        'height',
        'weight',
        'blood_type',
        'gsis_no',
        'pag-ibig_no',
        'philhealth_no',
        'sss_no',
        'agency_employee_no',
        'filipino',
        'dual_citizenship',
        'dual_citizenship_status',
        'country_id',
        'telephone_no',
        'mobile_no',
        'spouce_surname',
        'spouce_first_name',
        'spouce_middle_name',
        'spouce_name_extension',
        'spouce_occupation',
        'spouce_employer',
        'spouce_address',
        'spouce_telephone',
        'father_surname',
        'father_first_name',
        'father_middle_name',
        'father_name_extension',
        'mother_surname',
        'mother_first_name',
        'mother_middle_name',
    ];

    public function residentialAddress(){
        return $this->hasOne(Address::class, 'personal_information_id', 'id')->where('type', 'residential');
    }

    public function permanentAddress(){
        return $this->hasOne(Address::class, 'personal_information_id', 'id')->where('type', 'permanent');
    }
}

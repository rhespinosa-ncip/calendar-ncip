<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'pag_ibig_no',
        'philhealth_no',
        'sss_no',
        'tin_no',
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

    public function children(){
        return  $this->hasMany(Children::class, 'personal_information_id', 'id');
    }

    static function insertUpdate($request){
        $personalInformation = PersonalInformation::firstOrNew(array('user_id' => Auth::id()));
        $personalInformation->name_extension = $request->nameExtension;
        $personalInformation->date_of_birth = $request->dateOfBirth;
        $personalInformation->place_of_birth = $request->placeOfBirth;
        $personalInformation->sex = $request->sex;
        $personalInformation->civil_status = $request->civilStatus;
        $personalInformation->height = $request->height;
        $personalInformation->weight = $request->weight;
        $personalInformation->blood_type = $request->bloodType;
        $personalInformation->gsis_no = $request->gsisNo;
        $personalInformation->pag_ibig_no = $request->pagibigNo;
        $personalInformation->philhealth_no = $request->philhealthNo;
        $personalInformation->sss_no = $request->sssNo;
        $personalInformation->tin_no = $request->tinNo;
        $personalInformation->agency_employee_no = $request->agencyEmployeeNo;
        $personalInformation->filipino = $request->filipino == 'on' ? 'yes' : 'no';
        $personalInformation->dual_citizenship = $request->dualCitizenship == 'on' ? 'yes' : 'no';
        $personalInformation->dual_citizenship_status = $request->dualCitizenship;
        $personalInformation->country_id = $request->country;
        $personalInformation->telephone_no = $request->telephoneNo;
        $personalInformation->mobile_no = $request->mobileNo;
        $personalInformation->spouce_surname = $request->spouseSurname;
        $personalInformation->spouce_first_name = $request->spouseFirstName;
        $personalInformation->spouce_middle_name = $request->spouseMiddleName;
        $personalInformation->spouce_name_extension = $request->spouseNameExtension;
        $personalInformation->spouce_occupation = $request->spouseOccupation;
        $personalInformation->spouce_employer = $request->spouseEmployerOrBusinessName;
        $personalInformation->spouce_address = $request->spouseBusinessAddress;
        $personalInformation->spouce_telephone = $request->spouseTelephoneNo;
        $personalInformation->father_surname = $request->fatherSurname;
        $personalInformation->father_first_name = $request->fatherFirstName;
        $personalInformation->father_middle_name = $request->fatherMiddleName;
        $personalInformation->father_name_extension = $request->fatherExtension;
        $personalInformation->mother_surname = $request->motherSurname;
        $personalInformation->mother_first_name = $request->motherFirstName;
        $personalInformation->mother_middle_name = $request->motherMiddleName;
        $personalInformation->save();

        Children::insertUpdate($request, $personalInformation);
        Address::insertUpdate($request, $personalInformation);
        EducationLevel::insertUpdate($request);
        CivilEligibility::insertUpdate($request);
        WorkExperience::insertUpdate($request);
        VoluntaryWork::insertUpdate($request);
        LearningDevelopment::insertUpdate($request);
        OtherInformation::insertUpdate($request);
        References::insertUpdate($request);
        Questions::insertUpdate($request);
    }
}

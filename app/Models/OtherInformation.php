<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class OtherInformation extends Model
{
    use HasFactory;

    protected $table = 'other_information';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'type',
        'name',
    ];

    static function insertUpdate($request){
        OtherInformation::where([['user_id', Auth::id()]])->delete();

        foreach($request->specialSkillsAndHobbies as $key => $value){
            if($request->specialSkillsAndHobbies[$key] != ''){
                OtherInformation::create([
                    'user_id' => Auth::id(),
                    'type' => 'skills_hobbies',
                    'name' => $request->specialSkillsAndHobbies[$key],
                ]);
            }
        }

        foreach($request->nonAcademicDistinction as $key => $value){
            if($request->nonAcademicDistinction[$key] != ''){
                OtherInformation::create([
                    'user_id' => Auth::id(),
                    'type' => 'non_academic_recognition',
                    'name' => $request->nonAcademicDistinction[$key],
                ]);
            }
        }

        foreach($request->membershipAssociation as $key => $value){
            if($request->membershipAssociation[$key] != ''){
                OtherInformation::create([
                    'user_id' => Auth::id(),
                    'type' => 'membership_association',
                    'name' => $request->membershipAssociation[$key],
                ]);
            }
        }
    }
}

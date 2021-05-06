<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class WorkExperience extends Model
{
    use HasFactory;

    protected $table = 'work_experience';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'from',
        'to',
        'name',
        'monthly_salary',
        'salary_grade',
    ];

    static function insertUpdate($request){
        WorkExperience::where('user_id', Auth::id())->delete();
        
        foreach($request->careerService as $key => $value){
            if($request->careerService[$key] != ''){
                WorkExperience::create([
                    'user_id' => Auth::id(),
                    'from' => $request->workExperienceFrom[$key],
                    'to' => $request->workExperienceTo[$key],
                    'name' => $request->workExperienceCompany[$key],
                    'monthly_salary' => $request->workExperienceSalary[$key],
                    'salary_grade' => $request->workExperienceSalaryGrade[$key],
                ]);
            }
        }
    }
}

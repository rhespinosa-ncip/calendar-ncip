<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EducationLevel extends Model
{
    use HasFactory;

    protected $table = 'education_level';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'level',
        'name_of_school',
        'basic_education',
        'attendance_to',
        'attendance_from',
        'highest_level',
        'year_graduated',
        'scholarship',
    ];

    static function insertUpdate($request){
        $levels = array(
            'elementary','secondary','vocational/Trade Course','college','graduate Studies'
        );

        foreach($levels as $level){
            $levelTrimmed = str_replace('/', 'Or', str_replace(' ', '', $level));

            $educationLevel = EducationLevel::firstOrNew(array('user_id' => Auth::id(), 'level' => $levelTrimmed));

            $nameOfSchool = $levelTrimmed.'NameOfSchool';
            $basicEducation = $levelTrimmed.'BasicEducationOrDegreeOrCourse';
            $attendanceTo = $levelTrimmed.'To';
            $attendanceFrom = $levelTrimmed.'From';
            $highestLevel = $levelTrimmed.'HighestLevelOrUnitEarned';
            $yearGraduated = $levelTrimmed.'YearGraduated';
            $scholarship = $levelTrimmed.'ScholarshipAcademicHonorRecieved';

            $educationLevel->name_of_school = $request->$nameOfSchool;
            $educationLevel->basic_education = $request->$basicEducation;
            $educationLevel->attendance_to =  $request->$attendanceTo;
            $educationLevel->attendance_from =  $request->$attendanceFrom;
            $educationLevel->highest_level =  $request->$highestLevel;
            $educationLevel->year_graduated =  $request->$yearGraduated;
            $educationLevel->scholarship =  $request->$scholarship;
            $educationLevel->save();
        }

    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class LearningDevelopment extends Model
{
    use HasFactory;

    protected $table = 'learning_development';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title_of_learning',
        'from',
        'to',
        'number_of_hours',
        'type_of_ld',
        'conducted_by',
    ];

    static function insertUpdate($request){
        LearningDevelopment::where('user_id', Auth::id())->delete();

        foreach($request->learningAndDevelopmentTitleOfLearning as $key => $value){
            if($request->learningAndDevelopmentTitleOfLearning[$key] != ''){
                LearningDevelopment::create([
                    'user_id' => Auth::id(),
                    'title_of_learning' => $request->learningAndDevelopmentTitleOfLearning[$key],
                    'from' => $request->learningAndDevelopmentInclusiveDatesFrom[$key],
                    'to' => $request->learningAndDevelopmentInclusiveDatesTo[$key],
                    'number_of_hours' => $request->learningAndDevelopmentNumberOfHours[$key],
                    'type_of_ld' => $request->learningAndDevelopmentTypeOfLD[$key],
                    'conducted_by' => $request->learningAndDevelopmentconductedOrSponsoredBy[$key],
                ]);
            }
        }
    }
}

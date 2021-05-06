<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CivilEligibility extends Model
{
    use HasFactory;

    protected $table = 'civil_eligibility';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'career_service',
        'rating',
        'date_of_examination',
        'place_of_examination',
    ];

    static function insertUpdate($request){
        CivilEligibility::where('user_id', Auth::id())->delete();
        
        foreach($request->careerService as $key => $value){
            if($request->careerService[$key] != ''){
                CivilEligibility::create([
                    'user_id' => Auth::id(),
                    'career_service' => $request->careerService[$key],
                    'rating' => $request->careerServiceRating[$key],
                    'date_of_examination' => $request->careerServiceDate[$key],
                    'place_of_examination' => $request->careerServicePlace[$key],
                ]);
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VoluntaryWork extends Model
{
    use HasFactory;

    protected $table = 'voluntary_work';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'from',
        'to',
        'number_of_hours',
        'position',
    ];

    static function insertUpdate($request){
        VoluntaryWork::where('user_id', Auth::id())->delete();

        foreach($request->voluntaryWorknameAndAddress as $key => $value){
            if($request->voluntaryWorknameAndAddress[$key] != ''){
                VoluntaryWork::create([
                    'user_id' => Auth::id(),
                    'name' => $request->voluntaryWorknameAndAddress[$key],
                    'from' => $request->voluntaryWorkInclusiveDatesFrom[$key],
                    'to' => $request->voluntaryWorkInclusiveDatesTo[$key],
                    'number_of_hours' => $request->voluntaryWorkNumberOfHours[$key],
                    'position' => $request->voluntaryWorkPositionNatureOfWork[$key],
                ]);
            }
        }
    }

}

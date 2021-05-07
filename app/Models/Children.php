<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Children extends Model
{
    use HasFactory;

    protected $table = 'children';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'personal_information_id',
        'name',
        'date_of_birth',
    ];

    static function insertUpdate($request, $personalInformation){
        Children::where('personal_information_id', $personalInformation->id)->delete();

        foreach($request->nameOfChildren as $key => $value){
            if($request->nameOfChildren[$key] != ''){
                Children::create([
                    'personal_information_id' =>  $personalInformation->id,
                    'name' => $request->nameOfChildren[$key],
                    'date_of_birth' => $request->childrenDateOfBirth[$key],
                ]);
            }
        }
    }
}

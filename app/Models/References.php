<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class References extends Model
{
    use HasFactory;

    protected $table = 'references';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'telephone_no',
    ];

    static function insertUpdate($request){
        References::where('user_id', Auth::id())->delete();

        foreach($request->referencesName as $key => $value){
            if($request->referencesName[$key] != ''){
                References::create([
                    'user_id' => Auth::id(),
                    'name' => $request->referencesName[$key],
                    'address' => $request->referenceAddress[$key],
                    'telephone_no' => $request->referencesTelNo[$key],
                ]);
            }
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomplishment extends Model
{
    use HasFactory;

    protected $table = 'accomplishment_document';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'accomplishment',
        'remarks',
        'tito_id'
    ];

    static function insert($request){
        foreach($request->accomplishment as $key => $value){
            if($request->accomplishment[$key] != ''){
                self::insertData($request->accomplishment[$key], $request->remarks[$key], $request->titoId);
            }
        }

        AuditTrail::insert('Add accomplishment');

        return response()->json([
            'message' => 'success'
        ]);
    }

    static function insertData($accomplishment, $remarks, $titoId){
        Accomplishment::create([
            'accomplishment' => $accomplishment,
            'remarks' => $remarks ?? '',
            'tito_id' =>  $titoId
        ]);


    }

    static function updateData($request){
        $accomplishment = Accomplishment::where('tito_id', $request->titoId)->delete();

        return self::insert($request);
    }
}

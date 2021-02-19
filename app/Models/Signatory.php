<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class Signatory extends Model
{
    use HasFactory;

    protected $table = 'signatory';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'reviewed_by',
        'reviewed_by_position',
        'approved_by',
        'approved_by_position',
    ];

    static function validation($request){
        return Validator::make($request->all(), [
            'reviewedBy' => 'required',
            'reviewedByPosition' => 'required',
            'approvedBy' => 'required',
            'approvedByPosition' => 'required',
        ]);
    }

    static function insert($request){
        if(self::validation($request)->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => self::validation($request)->messages(),
            ]);
        }

        Signatory::create([
            'user_id' => Auth::id(),
            'reviewed_by' => $request->reviewedBy,
            'reviewed_by_position' => $request->reviewedByPosition,
            'approved_by' => $request->approvedBy,
            'approved_by_position' => $request->approvedByPosition,
        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    static function updateData($request){
        if(self::validation($request)->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => self::validation($request)->messages(),
            ]);
        }

        $signatory = Signatory::where('user_id', Auth::id())->first();

        if(isset($signatory)){
            if($request->status == 'remove'){
                $signatory->delete();
            }else{
                $signatory->reviewed_by = $request->reviewedBy;
                $signatory->reviewed_by_position = $request->reviewedByPosition;
                $signatory->approved_by = $request->approvedBy;
                $signatory->approved_by_position = $request->approvedByPosition;
                $signatory->save();
            }
        }else{
            return self::insert($request);
        }

        AuditTrail::insert('Update signatory');

        return response()->json([
            'message' => 'success',
        ]);
    }
}

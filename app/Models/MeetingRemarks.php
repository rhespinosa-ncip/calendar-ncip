<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MeetingRemarks extends Model
{
    use HasFactory;

    protected $table = 'meeting_remarks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'remarks',
        'meeting_schedule_id',
        'created_by',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    static function validation($request){
        $validate = Validator::make($request->all(),[
            'remarks' => 'required',
        ]);

        return $validate;
    }

    static function insert($request){
        $validate = self::validation($request);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        MeetingRemarks::create([
            'remarks' => $request->remarks,
            'meeting_schedule_id' => $request->meetingMinutesId,
            'created_by' => Auth::id(),
        ]);

        AuditTrail::insert('Add meeting remarks');

        return response()->json([
            'message' => 'success',
        ]);
    }
}

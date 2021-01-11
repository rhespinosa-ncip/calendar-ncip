<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Department extends Model
{
    use HasFactory;

    protected $table = 'department';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'hexa_color'
    ];

    static function validate($request){
        $id = $request->departmentId ?? 0;

        return $validate = Validator::make($request->all(), [
            'departmentName' => [
                'required',
                Rule::unique('department', 'name')->ignore($id ?? 0),
            ],
        ]);

    }

    static function insert($request){
        $validate = self::validate($request);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $color = substr(md5(rand()), 0, 6);

        $department = Department::create([
            'name' => $request->departmentName,
            'hexa_color' => '#'.$color
        ]);

        return response()->json([
            'message' => 'success',
        ]);
    }

    static function updateData($request){
        $validate = self::validate($request);

        if($validate->fails()){
            return response()->json([
                'message' => 'error-input',
                'messages' => $validate->messages(),
            ]);
        }

        $department = Department::find($request->departmentId);

        if(isset($department)){
            $department->name = $request->departmentName;
            $department->save();
        }

        return response()->json([
            'message' => 'success',
        ]);
    }
}

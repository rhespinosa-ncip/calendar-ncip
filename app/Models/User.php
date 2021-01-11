<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'position',
        'email',
        'username',
        'user_type',
        'department_id',
        'password',
    ];

    public function getFullnameAttribute(){
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    static function validate($request){
        $id = $request->userId ?? 0;

        return $validate = Validator::make($request->all(), [
            'firstName' => 'required',
            'middleName' => 'required',
            'lastName' => 'required',
            'departmentName' => 'required',
            'position' => 'required',
            'email' => [
                'required',
                'regex:/\S+@\S+\.\S+/',
                Rule::unique('users')->ignore($id ?? 0),
            ],
            'username' => [
                'required',
                Rule::unique('users')->ignore($id ?? 0),
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

        $password = 'ncip-'.str_replace(" ","",strtolower($request->firstName)).str_replace(" ","",strtolower($request->lastName));

        $user = User::create([
            'first_name' => $request->firstName,
            'middle_name' => $request->middleName,
            'last_name' => $request->lastName,
            'position' => $request->position,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($password),
            'department_id' => $request->departmentName,
            'user_type' => 'user'
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

        $user = User::whereId($request->userId)->first();

        if(isset($user)){
            $user->first_name = $request->firstName;
            $user->middle_name = $request->middleName;
            $user->last_name = $request->lastName;
            $user->position = $request->position;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->department_id = $request->departmentName;
            $user->save();
        }

        return response()->json([
            'message' => 'updateSuccess',
        ]);
    }
}

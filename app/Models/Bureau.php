<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Bureau extends Model
{
    use HasFactory;

    protected $table = 'bureau';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'hexa_color'
    ];

    public function users(){
        return $this->hasMany(User::class, 'bureau_id', 'id');
    }

    public function bureauDivision(){
        return $this->hasMany(BureauDivision::class, 'bureau_id', 'id');
    }

    static function validate($request){
        $id = $request->bureauId ?? 0;

        return $validate = Validator::make($request->all(), [
            'bureauName' => [
                'required',
                Rule::unique('bureau', 'name')->ignore($id ?? 0),
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

        $bureau = Bureau::create([
            'name' => $request->bureauName,
            'hexa_color' => '#'.$color
        ]);

        BureauDivision::insert($bureau->id, $request);

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

        $bureau = Bureau::find($request->bureauId);

        if(isset($bureau)){
            $bureau->name = $request->bureauName;
            $bureau->save();
        }

        BureauDivision::insert($bureau->id, $request);

        return response()->json([
            'message' => 'success',
        ]);
    }
}

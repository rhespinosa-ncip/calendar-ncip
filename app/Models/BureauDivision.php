<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BureauDivision extends Model
{
    use HasFactory;

    protected $table = 'bureau_division';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bureau_id',
        'department_id'
    ];

    public function department(){
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    static function insert($bureauId, $request){
        $deleteBureauDivision = BureauDivision::where('bureau_id', $bureauId)->delete();

        if(isset($request->department[0])){
            foreach($request->department as $key => $value){
                BureauDivision::create([
                    'bureau_id' => $bureauId,
                    'department_id' => $value,
                ]);
            }
        }
    }
}

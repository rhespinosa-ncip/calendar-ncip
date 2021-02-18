<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AuditTrail extends Model
{
    use HasFactory;
    protected $table = 'audit_trail';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event',
        'user_id',
    ];

    public function user(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    static function insert($event){
        AuditTrail::create([
            'user_id' => Auth::id(),
            'event' => $event
        ]);
    }
}

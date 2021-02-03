<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActionableItemStatus extends Model
{
    use HasFactory;
    protected $table = 'actionable_item_status';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'actionable_item_id',
    ];

    static function insert($status, $actionableId){
        ActionableItemStatus::create([
            'status' => $status,
            'actionable_item_id' => $actionableId,
        ]);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningDevelopment extends Model
{
    use HasFactory;

    protected $table = 'voluntary_work';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'title_of_learning',
        'from',
        'to',
        'type_of_ld',
        'conducted_by',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CivilEligibility extends Model
{
    use HasFactory;

    protected $table = 'civil_eligibility';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'career_service',
        'rating',
        'date_of_examination',
        'place_of_examination',
    ];
}

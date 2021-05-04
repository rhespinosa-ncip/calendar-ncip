<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationLevel extends Model
{
    use HasFactory;

    protected $table = 'education_level';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'level',
        'name_of_school',
        'basic_education',
        'attendance_to',
        'attendance_from',
        'highest_level',
        'year_graduated',
        'scholarship',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'course_level', 'course_type', 'course_duration', 'course_status', 'course_id', 'total_score'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherWiseCourse extends Model
{
    protected $fillable = [
        'teacher_id', 'course_id', 'department_id',
        'year', 'batch_id',
        'created_by', 'updated_by',
    ];
}

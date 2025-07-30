<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvaluationComment extends Model
{
    protected $fillable = [
        'department_id',
        'teacher_id',
        'student_id',
        'course_id',
        'comment_data',
        'year',
        'batch_id',
        'created_by',
        'updated_by',
    ];
}

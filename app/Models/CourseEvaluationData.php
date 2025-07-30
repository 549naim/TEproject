<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEvaluationData extends Model
{
    protected $fillable = [
        'department_id',
        'teacher_id',
        'student_id',
        'course_id',
        'question_id',
        'ratting',
        'year',
        'batch_id',
        'created_by',
        'updated_by',
    ];
}

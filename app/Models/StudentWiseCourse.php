<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentWiseCourse extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'department_id',
        'year',
        'batch_id',
        'created_by',
        'updated_by',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }
}

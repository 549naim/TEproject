<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseEvaluationData;
use App\Models\Department;
use App\Models\EvaluationSetting;
use App\Models\Question;
use App\Models\StudentWiseCourse;
use App\Models\TeacherWiseCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:dashboard', ['only' => ['index']]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::count();
        $departments = Department::count();
        $courses = Course::count();
        $student = StudentWiseCourse::distinct('student_id')->count('student_id');
        $teacher = TeacherWiseCourse::distinct('teacher_id')->count('teacher_id');
        $question = Question::count();
        $evaluatedCourses = CourseEvaluationData::distinct('course_id')->count('course_id');
        $evaluationDate = EvaluationSetting::latest()->first();

        return view('home', compact('users', 'departments', 'courses', 'student', 'teacher', 'question', 'evaluatedCourses', 'evaluationDate'));
    }
}

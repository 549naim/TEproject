<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseEvaluationComment;
use App\Models\CourseEvaluationData;
use App\Models\Department;
use App\Models\Question;
use App\Models\StudentWiseCourse;
use App\Models\TeacherWiseCourse;
use App\Models\User;
use App\Models\EvaluationSetting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:admin_create', ['only' => ['index', 'store', 'admin_edit', 'admin_update', 'admin_delete']]);
        $this->middleware('permission:student_evaluation', ['only' => ['evaluation_student', 'evaluation_student_course', 'evaluation_student_store']]);
        $this->middleware('permission:teacher_evaluation', ['only' => ['evaluation_teacher', 'evaluation_teacher_course']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::orderBy('id', 'desc');

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('roles', function ($row) {
                    return $row->getRoleNames()->map(function ($role) {
                        return '<span class="badge badge-success">' . $role . '</span>';
                    })->implode(' ');
                })
                ->addColumn('department', function ($row) {
                    if ($row->department && isset($row->department->name)) {
                        return '<span class="badge bg-info">' . e($row->department->name) . '</span>';
                    }
                    return '<span class="badge bg-secondary">N/A</span>';
                })
                ->addColumn('roll_no', function ($row) {
                    if (empty($row->roll_no)) {
                        return '<span class="badge bg-secondary">N/A</span>';
                    }
                    return '<span class="badge bg-info">' . e($row->roll_no) . '</span>';
                })
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_admin_modal" id="edit_admin" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_admin" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['action', 'roles', 'department', 'roll_no'])
                ->make(true);
        }

        $roles = Role::pluck('name', 'name')->all();
        $departments = Department::all();
        return view('admin.index', compact('roles', 'departments'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->except('confirm-password', 'roles');
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return response()->json([
            'success' => true,
            'message' => 'Admin created successfully!'
        ]);
    }

    public function admin_edit($id)
    {
        $admin = User::findOrFail($id);
        $roles = $admin->getRoleNames();

        return response()->json([
            'data' => $admin,
            'roles' => $roles
        ]);
    }

    public function admin_update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'roles' => 'required'
        ]);

        $admin = User::findOrFail($request->id);

        $admin->update($request->only(['name', 'email', 'dept_id', 'roll_no']));
        $admin->syncRoles($request->input('roles'));

        return response()->json([
            'success' => true,
            'message' => 'Admin updated successfully!'
        ]);
    }

    public function admin_delete($id)
    {
        $admin = User::findOrFail($id);
        $admin->delete();

        return response()->json([
            'success' => true,
            'message' => 'Admin deleted successfully!'
        ]);
    }

    public function evaluation_student()
    {
        $user = Auth::user();
        $batches = Batch::all();
        $questions = Question::all();

      
        $setting = EvaluationSetting::latest()->first();

        $now = Carbon::now();

        $evaluationOpen = false;

        if ($setting && $now->between($setting->start_date, $setting->end_date)) {
            $evaluationOpen = true;
        }

        return view('evaluation.student', compact('batches', 'user', 'questions', 'evaluationOpen'));
    }

    public function evaluation_student_course(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'batch_id' => 'required',
        ]);

        $user = Auth::user();

        $year = $request->year;
        $batch_id = $request->batch_id;
        $user_id = $user->id;
        $dept_id = $user->dept_id;

        $courseIds = StudentWiseCourse::where('year', $year)
            ->where('batch_id', $batch_id)
            ->where('student_id', $user_id)
            ->where('department_id', $dept_id)
            ->pluck('course_id');

        $courses = Course::whereIn('id', $courseIds)
            ->get(['id', 'name', 'code'])
            ->map(function ($course) use ($year, $batch_id, $dept_id, $user_id) {
                $teacher = TeacherWiseCourse::where('course_id', $course->id)
                    ->where('year', $year)
                    ->where('batch_id', $batch_id)
                    ->where('department_id', $dept_id)
                    ->first();

                $teacher_id = $teacher ? $teacher->teacher_id : null;

                // Check if already evaluated
                $alreadyEvaluated = CourseEvaluationData::where([
                    'department_id' => $dept_id,
                    'teacher_id' => $teacher_id,
                    'student_id' => $user_id,
                    'course_id' => $course->id,
                    'year' => $year,
                    'batch_id' => $batch_id,
                ])->exists();

                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'department_id' => $dept_id,
                    'teacher_id' => $teacher_id,
                    'student_id' => $user_id,
                    'year' => $year,
                    'batch_id' => $batch_id,
                    'evaluated' => $alreadyEvaluated,
                ];
            });

        return response()->json($courses);
    }

    public function evaluation_student_store(Request $request)
    {   
        $studentId = Auth::id();  // Currently logged in student

        // Prepare common conditions to check duplication
        $commonCheck = [
            'department_id' => $request->department_id,
            'teacher_id' => $request->teacher_id,
            'student_id' => $studentId,
            'course_id' => $request->course_id,
            'year' => $request->year,
            'batch_id' => $request->batch_id,
        ];

        $alreadyEvaluated = CourseEvaluationData::where($commonCheck)->exists();

        if ($alreadyEvaluated) {
            return response()->json(['message' => 'You have already evaluated this course.'], 409);  // 409 Conflict
        }

        $commonData = array_merge($commonCheck, [
            'created_by' => $studentId,
            'updated_by' => $studentId,
        ]);

        foreach ($request->ratings as $questionId => $ratting) {
            CourseEvaluationData::create(array_merge($commonData, [
                'question_id' => $questionId,
                'ratting' => $ratting,
            ]));
        }

        if (!empty($request->comment_data)) {
            CourseEvaluationComment::create(array_merge($commonData, [
                'comment_data' => $request->comment_data,
            ]));
        }

        return response()->json(['message' => 'Evaluation submitted successfully']);
    }

    public function evaluation_teacher()
    {
        $user = Auth::user();
        $batches = Batch::all();
        $questions = Question::all();
        return view('evaluation.teacher', compact('user', 'batches', 'questions'));
    }

    public function evaluation_teacher_course(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'batch_id' => 'required',
        ]);

        $user = Auth::user();

        $year = $request->year;
        $batch_id = $request->batch_id;
        $user_id = $user->id;
        $dept_id = $user->dept_id;

        $courseIds = TeacherWiseCourse::where('year', $year)
            ->where('batch_id', $batch_id)
            ->where('teacher_id', $user_id)
            ->where('department_id', $dept_id)
            ->pluck('course_id');

        $courses = Course::whereIn('id', $courseIds)
            ->get(['id', 'name', 'code'])
            ->map(function ($course) use ($year, $batch_id, $dept_id, $user_id) {
                $teacher = TeacherWiseCourse::where('course_id', $course->id)
                    ->where('year', $year)
                    ->where('batch_id', $batch_id)
                    ->where('department_id', $dept_id)
                    ->first();

                $teacher_id = $teacher ? $teacher->teacher_id : null;

                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'department_id' => $dept_id,
                    'teacher_id' => $user_id,
                    'year' => $year,
                    'batch_id' => $batch_id
                ];
            });

        return response()->json($courses);
    }

    public function evaluation_data(Request $request)
    {
        $course_id = $request->course_id;
        $department_id = $request->department_id;
        $teacher_id = $request->teacher_id;
        $year = $request->year;
        $batch_id = $request->batch_id;
        $question_ids = $request->question_ids;

        // 1. Average Ratings per Question
        $ratings = [];
        $totalAverageSum = 0;

        foreach ($question_ids as $question_id) {
            $averageRating = CourseEvaluationData::where([
                'course_id' => $course_id,
                'department_id' => $department_id,
                'teacher_id' => $teacher_id,
                'year' => $year,
                'batch_id' => $batch_id,
                'question_id' => $question_id,
            ])->avg('ratting');

            $roundedAvg = round($averageRating);
            $ratings[] = [
                'question_id' => $question_id,
                'average_rating' => $roundedAvg,
            ];

            $totalAverageSum += $roundedAvg;
        }

        // 2. Get all comments for this course
        $comments = CourseEvaluationComment::where([
            'course_id' => $course_id,
            'department_id' => $department_id,
            'teacher_id' => $teacher_id,
            'year' => $year,
            'batch_id' => $batch_id,
        ])->pluck('comment_data');

        // 3. Get number of unique students who gave ratings
        $uniqueStudentCount = CourseEvaluationData::where([
            'course_id' => $course_id,
            'department_id' => $department_id,
            'teacher_id' => $teacher_id,
            'year' => $year,
            'batch_id' => $batch_id,
        ])->distinct('student_id')->count('student_id');

        $totalEnrolledStudents = StudentWiseCourse::where([
            'course_id' => $course_id,
            'department_id' => $department_id,
            'year' => $year,
            'batch_id' => $batch_id,
        ])->distinct('student_id')->count('student_id');

        // Get teacher name
        $teacher = User::find($teacher_id);
        $teacher_name = $teacher ? $teacher->name : null;

        // Get course name and code
        $course = Course::find($course_id);
        $course_name = $course ? $course->name : null;
        $course_code = $course ? $course->code : null;

        // Get department name
        $department = Department::find($department_id);
        $department_name = $department ? $department->name : null;

        return response()->json([
            'status' => 'success',
            'ratings' => $ratings,
            'total_average_sum' => $totalAverageSum,
            'comments' => $comments,
            'total_students' => $uniqueStudentCount,
            'total_enrolled_students' => $totalEnrolledStudents,
            'teacher_name' => $teacher_name,
            'course_name' => $course_name,
            'course_code' => $course_code,
            'department_name' => $department_name,
            'year' => $year,
        ]);
    }

    public function downloadSample()
    {
        $filePath = public_path('assets/file/sample.xlsx');
        if (file_exists($filePath)) {
            return response()->download($filePath, 'sample.xlsx');
        }
        return response()->json(['error' => 'File not found.'], 404);
    }


}

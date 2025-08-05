<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;  // Assuming you have a Semester model
use App\Models\Course;  // Assuming you have a Course model
use App\Models\Department;  // Assuming you have a Department model
use App\Models\StudentWiseCourse;
use App\Models\TeacherWiseCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\Facades\DataTables;

class CourseUploadController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:course_upload', ['only' => ['index', 'importCourseData']]);
    }

    public function index(Request $request)
    {
        $departments = Department::all();
        $batches = Batch::all();
        return view('course_upload.index', compact('departments', 'batches'));
    }

    public function importCourseData(Request $request)
    {
        $request->validate([
            'year' => 'required|integer',
            'department_id' => 'required|exists:departments,id',
            'batch_id' => 'required|exists:batches,id',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('course_excel')) {
                $rows = Excel::toArray([], $request->file('course_excel'));

                $sheet = $rows[0];

                $courseRows = [];
                $studentRows = [];

                
                foreach ($sheet as $index => $row) {
                    if ($index == 0)
                        continue;  // header skip

                    $hasCourseData = !empty($row[0]) || !empty($row[1]) || !empty($row[2]) || !empty($row[3]);
                    $hasStudentData = !empty($row[4]) || !empty($row[5]) || !empty($row[6]);

                   
                    if ($hasCourseData) {
                        $courseRows[] = $row;
                    }

                  
                    if ($hasStudentData) {
                        $studentRows[] = $row;
                    }
                }

                if (empty($courseRows)) {
                    throw new \Exception('No course and teacher data found in file.');
                }

               
                $studentList = [];
                foreach ($studentRows as $row) {
                    $student_name = trim($row[4] ?? '');
                    $student_email = trim($row[5] ?? '');
                    $student_roll = trim($row[6] ?? '');

                    if (!$student_name || !$student_email || !$student_roll)
                        continue;

                    $student = User::firstOrCreate(
                        ['email' => $student_email],
                        [
                            'name' => $student_name,
                            'roll_no' => $student_roll,
                            'password' => Hash::make(str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT)),
                            'dept_id' => $request->department_id,
                        ]
                    );

                    if (!$student->hasRole('Student')) {
                        $student->assignRole('Student');
                    }

                    $studentList[] = $student;
                }

                
                foreach ($courseRows as $row) {
                    $course_name = trim($row[0]);
                    $course_code = trim($row[1]);
                    $teacher_name = trim($row[2]);
                    $teacher_email = trim($row[3]);

                    if (!$course_name || !$course_code || !$teacher_name || !$teacher_email)
                        continue;

                    $teacher = User::firstOrCreate(
                        ['email' => $teacher_email],
                        [
                            'name' => $teacher_name,
                            'password' => Hash::make(str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT)),
                            'dept_id' => $request->department_id,
                        ]
                    );

                    if (!$teacher->hasRole('Teacher')) {
                        $teacher->assignRole('Teacher');
                    }

                    $course = Course::firstOrCreate(
                        ['code' => $course_code],
                        [
                            'name' => $course_name,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                        ]
                    );

                    $twcExists = TeacherWiseCourse::where([
                        'teacher_id' => $teacher->id,
                        'course_id' => $course->id,
                        'department_id' => $request->department_id,
                        'batch_id' => $request->batch_id,
                        'year' => $request->year,
                    ])->exists();

                    if (!$twcExists) {
                        TeacherWiseCourse::create([
                            'teacher_id' => $teacher->id,
                            'course_id' => $course->id,
                            'department_id' => $request->department_id,
                            'batch_id' => $request->batch_id,
                            'year' => $request->year,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                        ]);
                    }

                   
                    foreach ($studentList as $student) {
                        $swcExists = StudentWiseCourse::where([
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'department_id' => $request->department_id,
                            'batch_id' => $request->batch_id,
                            'year' => $request->year,
                        ])->exists();

                        if (!$swcExists) {
                            StudentWiseCourse::create([
                                'student_id' => $student->id,
                                'course_id' => $course->id,
                                'department_id' => $request->department_id,
                                'batch_id' => $request->batch_id,
                                'year' => $request->year,
                                'created_by' => auth()->id(),
                                'updated_by' => auth()->id(),
                            ]);
                        }
                    }
                }

                DB::commit();
            } else {
                // Validation: If teacher or student is given, course_name must be present
                if (
                    (filled($request->teacher_name) || filled($request->teacher_email) || filled($request->student_name) || filled($request->student_email)) &&
                    !filled($request->course_name)
                ) {
                    throw new \Exception('Course name is required when inserting teacher or student.');
                }

                if (filled($request->course_code)) {
                    $course = Course::where('code', $request->course_code)->first();

                    if (!$course && filled($request->course_name)) {
                        $course = Course::create([
                            'name' => $request->course_name,
                            'code' => $request->course_code,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id()
                        ]);
                    }
                } else {
                    $course = null;
                }

                // যদি Teacher ইনপুট থাকে
                if (filled($request->teacher_name) && filled($request->teacher_email) && $course) {
                    $teacher = User::firstOrCreate(
                        ['email' => trim($request->teacher_email)],
                        [
                            'name' => $request->teacher_name,
                            'password' => Hash::make(str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT)),
                            'dept_id' => $request->department_id,
                        ]
                    );

                    if (!$teacher->hasRole('Teacher')) {
                        $teacher->assignRole('Teacher');
                    }

                    // TeacherWiseCourse check & create
                    $exists = TeacherWiseCourse::where([
                        'teacher_id' => $teacher->id,
                        'course_id' => $course->id,
                        'department_id' => $request->department_id,
                        'batch_id' => $request->batch_id,
                        'year' => $request->year,
                    ])->exists();

                    if (!$exists) {
                        TeacherWiseCourse::create([
                            'teacher_id' => $teacher->id,
                            'course_id' => $course->id,
                            'department_id' => $request->department_id,
                            'batch_id' => $request->batch_id,
                            'year' => $request->year,
                            'created_by' => auth()->id(),
                            'updated_by' => auth()->id(),
                        ]);
                    }
                }

                // যদি Student ইনপুট থাকে
                if (!empty($request->student_name) && !empty($request->student_email) && $course) {
                    $names = $request->student_name;
                    $emails = $request->student_email;

                    foreach ($names as $index => $student_name) {
                        $student_email = trim($emails[$index] ?? '');

                        if (!$student_name || !$student_email)
                            continue;

                        $student = User::firstOrCreate(
                            ['email' => $student_email],
                            [
                                'name' => $student_name,
                                'password' => Hash::make(str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT)),
                                'dept_id' => $request->department_id,
                            ]
                        );

                        if (!$student->hasRole('Student')) {
                            $student->assignRole('Student');
                        }

                        $exists = StudentWiseCourse::where([
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'department_id' => $request->department_id,
                            'batch_id' => $request->batch_id,
                            'year' => $request->year,
                        ])->exists();

                        if (!$exists) {
                            StudentWiseCourse::create([
                                'student_id' => $student->id,
                                'course_id' => $course->id,
                                'department_id' => $request->department_id,
                                'batch_id' => $request->batch_id,
                                'year' => $request->year,
                                'created_by' => auth()->id(),
                                'updated_by' => auth()->id(),
                            ]);
                        }
                    }
                }
            }

            DB::commit();

            return response()->json([
                'status' => 'success',
                'message' => 'Course data successfully imported.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);
        }
    }
}

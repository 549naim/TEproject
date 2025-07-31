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
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

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

                DB::beginTransaction();

                $headerRow = $rows[0][0] ?? [];
                $firstDataRow = null;
                foreach ($rows[0] as $index => $row) {
                    if ($index == 0)
                        continue;
                    if (!empty($row[0]) && !empty($row[1]) && !empty($row[2]) && !empty($row[3])) {
                        $firstDataRow = $row;
                        break;
                    }
                }

                if (!$firstDataRow) {
                    throw new \Exception('Course and teacher information not found.');
                }

                $course_name = $firstDataRow[0];
                $course_code = $firstDataRow[1];
                $teacher_name = $firstDataRow[2];
                $teacher_email = $firstDataRow[3];

                $teacher = User::firstOrCreate(
                    ['email' => trim($teacher_email)],
                    [
                        'name' => $teacher_name,
                        'password' => Hash::make(str_pad(mt_rand(0, 99999999), 8, '0', STR_PAD_LEFT)),
                        'dept_id' => $request->department_id,
                    ]
                );
                if (!$teacher->hasRole('Teacher')) {
                    $teacher->assignRole('Teacher');
                }

                $course = Course::where('code', $course_code)->first();
                if (!$course) {
                    $course = Course::create([
                        'name' => $course_name,
                        'code' => $course_code,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id()
                    ]);
                }

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

                foreach ($rows[0] as $index => $row) {
                    if ($index == 0)
                        continue;
                    $student_name = $row[4] ?? null;
                    $student_email = trim($row[5] ?? '');

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

                    // StudentWiseCourse insert only if same data doesn't exist
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

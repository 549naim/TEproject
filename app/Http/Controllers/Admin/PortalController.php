<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotifyStudentMail;
use App\Mail\NotifyTeacherMail;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\EmailRecord;
use App\Models\EvaluationSetting;
use App\Models\Question;
use App\Models\StudentWiseCourse;
use App\Models\TeacherWiseCourse;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PortalController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:department_management', ['only' => ['departmentIndex', 'departmentStore', 'departmentShow', 'departmentUpdate', 'departmentDelete']]);
        $this->middleware('permission:batch_management', ['only' => ['batchIndex', 'batchStore', 'batchShow', 'batchUpdate', 'batchDelete']]);
        $this->middleware('permission:course_management', ['only' => ['courseIndex', 'courseStore', 'courseShow', 'courseUpdate', 'courseDelete']]);
        $this->middleware('permission:evaluation_setting', ['only' => ['evaluation_settings', 'evaluation_settings_store', 'sendEmail', 'sendFilteredEmail']]);
        $this->middleware('permission:evaluation_report', ['only' => ['evaluation_report', 'evaluation_teacher_report']]);
    }

    public function departmentIndex()
    {
        if (request()->ajax()) {
            $questions = Department::orderBy('id', 'desc');
            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_department_modal" id="edit_department" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    // $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_department" data-id="' . $row->id . '">
                    //         <i class="fas fa-trash"></i>
                    //     </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('department.index');
    }

    public function batchIndex()
    {
        if (request()->ajax()) {
            $questions = Batch::orderBy('id', 'desc');
            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_batch_modal" id="edit_batch" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    // $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_batch" data-id="' . $row->id . '">
                    //         <i class="fas fa-trash"></i>
                    //     </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('batch.index');
    }

    public function courseIndex()
    {
        $departments = Department::all();
        $batches = Batch::all();
        $courses = Course::all();
        return view('course.index', compact('departments', 'batches', 'courses'));
    }

    public function departmentStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name',
            'code' => 'required|string|max:10|unique:departments,code',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        Department::create($data);
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }

    public function departmentShow($id)
    {
        $department = Department::findOrFail($id);
        return response()->json($department);
    }

    public function departmentUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $request->id,
            'code' => 'required|string|max:10|unique:departments,code,' . $request->id,
        ]);

        $department = Department::findOrFail($request->id);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $data['updated_at'] = now();
        $department->update($data);
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }

    public function departmentDelete($id)
    {
        $department = Department::findOrFail($id);
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }

    public function batchStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:batches,name',
            'year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        Batch::create($data);
        return redirect()->route('batches.index')->with('success', 'Batch created successfully.');
    }

    public function batchShow($id)
    {
        $batch = Batch::findOrFail($id);
        return response()->json($batch);
    }

    public function batchUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:batches,name,' . $request->id,
            'year' => 'required|integer|min:2000|max:' . date('Y'),
        ]);

        $batch = Batch::findOrFail($request->id);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $data['updated_at'] = now();
        $batch->update($data);
        return redirect()->route('batches.index')->with('success', 'Batch updated successfully.');
    }

    public function batchDelete($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();
        return redirect()->route('batches.index')->with('success', 'Batch deleted successfully.');
    }

    public function courseStore(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'batch_id' => 'required',
            'department_id' => 'required',
        ]);

        $year = $request->year;
        $batch_id = $request->batch_id;
        $dept_id = $request->department_id;

        $courseIds = TeacherWiseCourse::where('year', $year)
            ->where('batch_id', $batch_id)
            ->where('department_id', $dept_id)
            ->pluck('course_id');

        $courses = Course::whereIn('id', $courseIds)
            ->get(['id', 'name', 'code'])
            ->map(function ($course) use ($year, $batch_id, $dept_id) {
                $teacher = TeacherWiseCourse::where('course_id', $course->id)
                    ->where('year', $year)
                    ->where('batch_id', $batch_id)
                    ->where('department_id', $dept_id)
                    ->first();

                $teacher_id = $teacher ? $teacher->teacher_id : null;
                $teacher_name = $teacher ? User::find($teacher_id)->name : 'N/A';

                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'department_id' => $dept_id,
                    'teacher_id' => $teacher_id,
                    'year' => $year,
                    'batch_id' => $batch_id,
                    'teacher_name' => $teacher_name,
                ];
            });

        return response()->json($courses);
    }

    public function courseShow($id)
    {
        $course = Course::findOrFail($id);
        return response()->json($course);
    }

    public function courseUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:courses,name,' . $request->id,
            'code' => 'required|string|max:10|unique:courses,code,' . $request->id,
        ]);

        $course = Course::findOrFail($request->id);
        $data = $request->all();
        $data['updated_by'] = auth()->id();
        $data['updated_at'] = now();
        $course->update($data);
        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function courseDelete($id)
    {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }

    public function evaluation_settings()
    {
        $departments = Department::all();
        $batches = Batch::all();
        $courses = Course::all();
        $evaluationSetting = EvaluationSetting::latest()->first();

        $isEvaluationOpen = false;

        if ($evaluationSetting) {
            $currentDate = now();
            $startDate = \Carbon\Carbon::parse($evaluationSetting->start_date);
            $endDate = \Carbon\Carbon::parse($evaluationSetting->end_date);

            $isEvaluationOpen = $currentDate->between($startDate, $endDate);

            return view('evaluation.setting', compact(
                'evaluationSetting',
                'departments',
                'batches',
                'courses',
                'isEvaluationOpen'
            ));
        } else {
            return view('evaluation.setting', compact(
                'evaluationSetting',
                'departments',
                'batches',
                'courses',
                'isEvaluationOpen'
            ));
        }
    }

    public function evaluation_settings_store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        EvaluationSetting::create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);
        $evaluationDate = EvaluationSetting::latest()->first();
        $isEvaluationOpen = false;
        if ($evaluationDate) {
            $currentDate = now();
            $startDate = \Carbon\Carbon::parse($evaluationDate->start_date);
            $endDate = \Carbon\Carbon::parse($evaluationDate->end_date);

            $isEvaluationOpen = $currentDate->between($startDate, $endDate);
        }
        return response()->json([
            'message' => 'Evaluation settings saved successfully.',
            'data' => $evaluationDate,
            'isEvaluationOpen' => $isEvaluationOpen
        ]);
    }

    public function sendEmail()
    {
        $subject = 'Teaching Evaluation Notice';

        $setting = EvaluationSetting::latest()->first();
        if (!$setting) {
            return response()->json(['message' => 'No evaluation setting found.'], 404);
        }
        $startDate = \Carbon\Carbon::parse($setting->start_date)->format('F j, Y');
        $endDate = \Carbon\Carbon::parse($setting->end_date)->format('F j, Y');

        // $loginUrl = route('login');

        $users = User::all();
        $studentEmails = [];

        foreach ($users as $user) {
            if ($user->hasRole('Student') && $user->email) {
                $studentEmails[] = $user->email;
            }
        }

        if (empty($studentEmails)) {
            return response()->json(['message' => 'No student emails found.'], 404);
        }
        // $bodyText = "Dear Student,\n\nPlease complete your teaching evaluation between <b>$startDate</b> and <b>$endDate</b>.\nClick the link below to log in and proceed.\nThank you.";
        $year = date('Y');
        $departmentId = null;
        $batchId = null;

        Mail::to(env('MAIL_TO_ADDRESS'))
            ->bcc($studentEmails)
            ->cc(env('MAIL_CC_ADDRESS'))
            ->send(new NotifyStudentMail($subject, $startDate, $endDate, $year, $departmentId, $batchId));
        EmailRecord::create([
            'year' => $year,
            'department_id' => $departmentId,
            'batch_id' => $batchId,
            'email_subject' => $subject,
        ]);

        return response()->json(['message' => 'Mail sent to all students successfully.']);
    }

    public function sendFilteredEmail(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'year' => 'required',
            'batch_id' => 'nullable|exists:batches,id',
        ]);

        $department = Department::findOrFail($request->department_id);

        $query = StudentWiseCourse::where('department_id', $department->id)
            ->where('year', $request->year);

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        $studentIds = $query->pluck('student_id');

        $users = User::whereIn('id', $studentIds)->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No students found for the selected filters.']);
        }

        $subject = 'Teaching Evaluation Notice';
        $evaluationSetting = EvaluationSetting::latest()->first();
        $startDate = \Carbon\Carbon::parse($evaluationSetting->start_date)->format('F j, Y');
        $endDate = \Carbon\Carbon::parse($evaluationSetting->end_date)->format('F j, Y');

        $year = $request->year;
        $departmentId = $request->department_id;
        $batchId = $request->batch_id;

        Mail::to(env('MAIL_TO_ADDRESS'))
            ->bcc($users->pluck('email'))
            ->cc(env('MAIL_CC_ADDRESS'))
            ->send(new NotifyStudentMail($subject, $startDate, $endDate, $year, $departmentId, $batchId));
        EmailRecord::create([
            'year' => $year,
            'department_id' => $departmentId,
            'batch_id' => $batchId,
            'email_subject' => $subject,
        ]);

        return response()->json(['message' => 'Mail sent to all students successfully.']);
    }

    public function evaluation_report()
    {
        $departments = Department::all();
        $batches = Batch::all();
        $courses = Course::all();
        $questions = Question::all();

        return view('evaluation.report', compact('departments', 'batches', 'courses', 'questions'));
    }

    public function evaluation_teacher_report(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'batch_id' => 'required',
            'department_id' => 'required',
        ]);

        $year = $request->year;
        $batch_id = $request->batch_id;
        $dept_id = $request->department_id;

        $courseIds = TeacherWiseCourse::where('year', $year)
            ->where('batch_id', $batch_id)
            ->where('department_id', $dept_id)
            ->pluck('course_id');

        $courses = Course::whereIn('id', $courseIds)
            ->get(['id', 'name', 'code'])
            ->map(function ($course) use ($year, $batch_id, $dept_id) {
                $teacher = TeacherWiseCourse::where('course_id', $course->id)
                    ->where('year', $year)
                    ->where('batch_id', $batch_id)
                    ->where('department_id', $dept_id)
                    ->first();

                $teacher_id = $teacher ? $teacher->teacher_id : null;
                $teacher_name = $teacher ? User::find($teacher_id)->name : 'N/A';

                return [
                    'id' => $course->id,
                    'name' => $course->name,
                    'code' => $course->code,
                    'department_id' => $dept_id,
                    'teacher_id' => $teacher_id,
                    'year' => $year,
                    'batch_id' => $batch_id,
                    'teacher_name' => $teacher_name,
                ];
            });

        return response()->json($courses);
    }

    public function emailRecord()
    {
        if (request()->ajax()) {
            $records = EmailRecord::orderBy('id', 'desc');

            return DataTables::of($records)
                ->addIndexColumn()
                ->addColumn('department', function ($row) {
                    if ($row->department_id) {
                        $department = Department::find($row->department_id);
                        return $department ? $department->name : '<span class="badge bg-secondary">Unknown</span>';
                    }
                    return '<span class="badge bg-info">All</span>';
                })
                ->addColumn('batch', function ($row) {
                    if ($row->batch_id) {
                        $batch = Batch::find($row->batch_id);
                        return $batch ? $batch->name : '<span class="badge bg-secondary">Unknown</span>';
                    }
                    return '<span class="badge bg-info">All</span>';
                })
                ->addColumn('sending_date', function ($row) {
                    return \Carbon\Carbon::parse($row->created_at)->format('d M, Y ');
                })
                ->rawColumns(['department', 'batch'])
                ->make(true);
        }

        return view('course.setting');
    }

    public function course_student_list(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'batch_id' => 'required',
            'department_id' => 'required',
            'course_id' => 'required',
            'teacher_id' => 'required',
            'course_name' => 'required'
        ]);

        $year = $request->year;
        $batch_id = $request->batch_id;
        $department_id = $request->department_id;
        $course_id = $request->course_id;
        $teacher_id = $request->teacher_id;
        $course_name = $request->course_name;

        // Fetch student IDs from StudentWiseCourse based on filters
        $studentIds = StudentWiseCourse::where('year', $year)
            ->where('batch_id', $batch_id)
            ->where('department_id', $department_id)
            ->where('course_id', $course_id)
            ->pluck('student_id');

        $total_students = $studentIds->count();

        // Fetch student details from User table
        $student_data = User::whereIn('id', $studentIds)
            ->get(['id', 'name', 'email', 'roll_no']);
        $teacher_name = User::find($teacher_id)->name;
        $course_code = Course::find($course_id)->code;

        return response()->json([
            'total_students' => $total_students,
            'student_data' => $student_data,
            'teacher_name' => $teacher_name,
            'course_name' => $course_name,
            'course_code' => $course_code
        ]);
    }

    public function sendEmailAllTeacher()
    {
        $subject = 'Teaching Evaluation Report Notice';

        if (!$setting) {
            return response()->json(['message' => 'No evaluation setting found.'], 404);
        }
        $users = User::all();
        $teacherEmails = [];

        foreach ($users as $user) {
            if ($user->hasRole('Teacher') && $user->email) {
                $teacherEmails[] = $user->email;
            }
        }

        if (empty($teacherEmails)) {
            return response()->json(['message' => 'No teacher emails found.'], 404);
        }
        // $bodyText = "Dear Teacher,\n\nPlease complete your teaching evaluation between <b>$startDate</b> and <b>$endDate</b>.\nClick the link below to log in and proceed.\nThank you.";
        $year = date('Y');
        $departmentId = null;
        $batchId = null;

        Mail::to(env('MAIL_TO_ADDRESS'))
            ->bcc($teacherEmails)
            ->cc(env('MAIL_CC_ADDRESS'))
            ->send(new NotifyTeacherMail($subject));
        EmailRecord::create([
            'year' => $year,
            'department_id' => $departmentId,
            'batch_id' => $batchId,
            'email_subject' => $subject,
        ]);

        return response()->json(['message' => 'Mail sent to all students successfully.']);
    }


    public function sendFilteredEmailTeacher(Request $request)
    {
        $request->validate([
            'department_id' => 'required|exists:departments,id',
            'year' => 'required',
            'batch_id' => 'nullable|exists:batches,id',
        ]);

        $department = Department::findOrFail($request->department_id);

        $query = TeacherWiseCourse::where('department_id', $department->id)
            ->where('year', $request->year);

        if ($request->filled('batch_id')) {
            $query->where('batch_id', $request->batch_id);
        }

        $teacherIds = $query->pluck('teacher_id')->unique();

        $users = User::whereIn('id', $teacherIds)->get();

        if ($users->isEmpty()) {
            return response()->json(['message' => 'No teachers found for the selected filters.']);
        }

        $subject = 'Teaching Evaluation Report Notice';
       
        $year = $request->year;
        $departmentId = $request->department_id;
        $batchId = $request->batch_id;

        Mail::to(env('MAIL_TO_ADDRESS'))
            ->bcc($users->pluck('email'))
            ->cc(env('MAIL_CC_ADDRESS'))
            ->send(new NotifyTeacherMail($subject));
        EmailRecord::create([
            'year' => $year,
            'department_id' => $departmentId,
            'batch_id' => $batchId,
            'email_subject' => $subject,
        ]);

        return response()->json(['message' => 'Mail sent to all teachers successfully.']);

    }


}

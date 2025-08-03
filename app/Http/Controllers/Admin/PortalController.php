<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NotifyStudentMail;
use App\Models\Batch;
use App\Models\Course;
use App\Models\Department;
use App\Models\EvaluationSetting;
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

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_department" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
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

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_batch" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('batch.index');
    }

    public function courseIndex()
    {
        if (request()->ajax()) {
            $questions = Course::orderBy('id', 'desc');
            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_course_modal" id="edit_course" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_course" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('course.index');
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
            'name' => 'required|string|max:255|unique:courses,name',
            'code' => 'required|string|max:10|unique:courses,code',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        Course::create($data);
        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
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
        $evaluationSetting = EvaluationSetting::latest()->first();
        if ($evaluationSetting) {
            return view('evaluation.setting', compact('evaluationSetting'));
        } else {
            return view('evaluation.setting');
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
        return response()->json([
            'message' => 'Evaluation settings saved successfully.',
            'data' => $evaluationDate
        ]);
    }

    public function sendEmail()
    {
        $subject = 'Teaching Evaluation Notice';

        // Latest evaluation setting
        $setting = EvaluationSetting::latest()->first();

        if (!$setting) {
            return response()->json(['message' => 'No evaluation setting found.'], 404);
        }

        $startDate = \Carbon\Carbon::parse($setting->start_date)->format('F j, Y');
        $endDate = \Carbon\Carbon::parse($setting->end_date)->format('F j, Y');

        $body = "Dear Student,\n\nPlease complete your teaching evaluation between **$startDate** and **$endDate**.\nClick the link below to log in and proceed:\n\n";

        $users = User::all();
        foreach ($users as $user) {
            if ($user->hasRole('Student')) {
                Mail::to($user->email)->send(new NotifyStudentMail($subject, $body));
            }
        }

        return response()->json(['message' => 'Emails sent to all students successfully.']);
    }
}

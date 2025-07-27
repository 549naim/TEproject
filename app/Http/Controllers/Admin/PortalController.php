<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use Yajra\DataTables\DataTables;
use App\Models\Batch;
use App\Models\Course;

class PortalController extends Controller
{
    public function departmentIndex()
    {
        if (request()->ajax()) {
            $questions = Department::orderBy('id', 'desc');
            return DataTables::of($questions)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_question_modal" id="edit_question" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_question" data-id="' . $row->id . '">
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
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_question_modal" id="edit_question" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_question" data-id="' . $row->id . '">
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
                    $btn = '<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#edit_question_modal" id="edit_question" data-id="' . $row->id . '">
                            <i class="fas fa-pen"></i>
                        </button>';

                    $btn .= ' <button type="button" class="btn btn-danger btn-sm" id="delete_question" data-id="' . $row->id . '">
                            <i class="fas fa-trash"></i>
                        </button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('course.index');
    }
}

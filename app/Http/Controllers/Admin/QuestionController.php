<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Spatie\Permission\Models\Permission;

class QuestionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:question_management', ['only' => ['index', 'store', 'show', 'update', 'destroy']]);
    }

    public function index()
    {
        if (request()->ajax()) {
            $questions = Question::orderBy('id', 'desc');
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
        return view('question.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
        ]);

        $question = Question::create([
            'question' => $request->question,
        ]);

        return response()->json(['success' => true, 'message' => 'Question uploaded successfully.']);
    }

    public function show(Question $question)
    {
        return response()->json(['data' => $question]);
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required|string|max:255',
        ]);

        $question->update([
            'question' => $request->question,
        ]);

        return response()->json(['message' => 'Question updated successfully.']);
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(['message' => 'Question deleted successfully.']);
    }
}

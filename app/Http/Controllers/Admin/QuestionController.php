<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Submission;
use App\Services\Scoring;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private function validated(Request $request): array
    {
     $data = $request->validate([
         'title' => ['required', 'string', 'max:120'],
         'body' => ['required', 'string'],
         'type' => ['required', 'in:multiple_choice,open'],
         'points' => ['required', 'integer', 'min:1', 'max:100'],
         'explanation' => ['nullable', 'string'],
         'options' => ['required_if:type,multiple_choice', 'array', 'min:2'],
         'options.*' => ['required_if:type,multiple_choice', 'string', 'max:120'],
         'correct_option' => ['required_if:type,multiple_choice', 'nullable', 'integer'],
         'is_active' => ['boolean'],
     ]);
     if ($data['type'] === 'open') {
         $data['options'] = null;
         $data['correct_option'] = null;
     }
     return $data;
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $question = Question::create($this->validated($request));
        return redirect()
            ->route('admin.questions.edit')
            ->with('status', 'Vraag aangemaakt - de QR code staat hieronder.');
    }

    public function qr(Question $question)
    {
        return response(QrCode::size(600)->generate($question->playUrl()))
            ->header('Content-type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename=' . $question->token. '.svg');
    }

    public function submit(Request $request, Question $question, Scoring $scoring)
    {
        $student = $request->attributes->get('student');
        $submission = Submission::where('student_id', $student->id)
            ->where('question_id', $question->id)->firstOrFail();

        abort_if($submission->submitted_at, 403, 'Je hebt deze vraag al beantwoord.');

        $input = $request->validate($question->isOpen()
            ? ['answer_text' => ['required', 'string', 'max:2000']]
            : ['selected_option' => ['required', 'integer', 'min:0']]
        );

        $scoring->grade($submission, $question, $input);

        return redirect()->route('play.show', $question);
    }

    public function draft(Request $request, Question $question)
    {
        $student = $request->attributes->get('student');
        $submission = Submission::where('student_id', $student->id)
            ->where('question_id', $question->id)->firstOrFail();

        if(! $submission->submitted_at) {
            $submission->update(['answer_text' => $request->input('answer_text')]);
        }
        return response()->noContent();
    }


    public function print()
    {
        $questions = Question::where('is_active', true)
            ->orderBy('title')
            ->get()
            ->map(function (Question $question) {
                $question->qrSvg = QrCode::size(220)->margin(0)->generate($question->playUrl());
                return $question;
            });

        return view('admin.questions.print', compact('questions'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::orderByDesc('created_at')->get();

        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('admin.questions.create');
    }

    public function store(Request $request)
    {
        $question = Question::create($this->validated($request));

        return redirect()
            ->route('admin.questions.edit', $question)
            ->with('status', 'Vraag aangemaakt — de QR-code staat hieronder.');
    }

    public function edit(Question $question)
    {
        return view('admin.questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $question->update($this->validated($request));

        return back()->with('status', 'Vraag bijgewerkt.');
    }

    public function destroy(Question $question)
    {
        $question->delete();

        return redirect()->route('admin.questions.index')->with('status', 'Vraag verwijderd.');
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

    private function validated(Request $request): array
    {
        if ($request->filled('options_raw')) {
            $request->merge([
                'options' => array_values(array_filter(
                    array_map('trim', explode("\n", $request->input('options_raw')))
                )),
            ]);
        }

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

        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}

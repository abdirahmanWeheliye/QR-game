<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        $filename = 'qrgame-resultaten-' .now()->format('Y-m-d-Hi') . '.csv';

        return response()-streamDownlaod(function() {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['studentnummer', 'naam', 'vraag', 'type', 'antwoord', 'status', 'punten', 'ingeleverd_op']);

                Submission::with(['student', 'question'])
                    ->whereNotNull('submitted_at')
                    ->chunk(200, function ($rows) use ($out) {
                        foreach ($rows as $s) {
                            fputcsv($out, [
                                $s->student->student_number,
                                $s->student->name,
                                $s->question->title,
                                $s->question->type,
                                $s->answer_text ?? ($s->question->options[$s->selected_option] ?? ''),
                                $s->status,
                                $s->points_awarded,
                                $s->submitted_at,
                            ]);
                        }
                    });
                fclose($out);
            }, $filename, ['Content_Type' => 'text/csv']);
    }
}

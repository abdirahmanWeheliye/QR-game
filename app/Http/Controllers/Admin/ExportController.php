<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Submission;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    public function __invoke(): StreamedResponse
    {
        $filename = 'qrgame-resultaten-'.now()->format('Y-m-d-Hi').'.csv';

        return response()->streamDownload(function () {
            $out = fopen('php://output', 'w');
            $write = fn (array $row) => fputcsv($out, $row, ';', '"', '');

            // BOM zodat Excel de UTF-8-tekens goed leest
            fwrite($out, "\xEF\xBB\xBF");

            $write(['studentnummer', 'naam', 'vraag', 'type', 'antwoord', 'status', 'punten', 'ingeleverd_op']);

            Submission::with(['student', 'question'])
                ->whereNotNull('submitted_at')
                ->chunk(200, function ($rows) use ($write) {
                    foreach ($rows as $s) {
                        $write([
                            $s->student->student_number,
                            $s->student->name,
                            $s->question->title,
                            $s->question->type,
                            $s->answer_text ?? ($s->question->options[$s->selected_option] ?? ''),
                            $s->status,
                            $s->points_awarded,
                            (string) $s->submitted_at,
                        ]);
                    }
                });

            fclose($out);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }
}

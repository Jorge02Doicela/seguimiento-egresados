<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports');
    }

    public function excel()
    {
        $questions = Question::with('answers')->get();

        $results = $questions->map(function ($question) {
            $total = $question->answers->count();

            $average = null;
            if ($question->type === 'scale') {
                $sum = 0;
                $count = 0;

                foreach ($question->answers as $answer) {
                    // Aquí esperamos que answer_text sea un número simple o JSON con números
                    $value = null;
                    $decoded = json_decode($answer->answer_text, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        foreach ($decoded as $val) {
                            if (is_numeric($val)) {
                                $value = (float) $val;
                                break;
                            }
                        }
                    } else {
                        if (is_numeric($answer->answer_text)) {
                            $value = (float) $answer->answer_text;
                        }
                    }

                    if (!is_null($value)) {
                        $sum += $value;
                        $count++;
                    }
                }

                $average = $count > 0 ? $sum / $count : null;
            }

            return (object) [
                'question_text' => $question->question_text,
                'type' => $question->type,
                'total_answers' => $total,
                'average_score' => $average,
            ];
        });

        return view('admin.surveys.report_excel', compact('results'));
    }


    public function pdf()
    {
        $questions = Question::with('answers')->get();

        $results = $questions->map(function ($question) {
            $total = $question->answers->count();

            $average = null;
            if ($question->type === 'scale') {
                $sum = 0;
                $count = 0;

                foreach ($question->answers as $answer) {
                    $value = null;
                    $decoded = json_decode($answer->answer_text, true);

                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        foreach ($decoded as $val) {
                            if (is_numeric($val)) {
                                $value = (float) $val;
                                break;
                            }
                        }
                    } else {
                        if (is_numeric($answer->answer_text)) {
                            $value = (float) $answer->answer_text;
                        }
                    }

                    if (!is_null($value)) {
                        $sum += $value;
                        $count++;
                    }
                }

                $average = $count > 0 ? $sum / $count : null;
            }

            return (object) [
                'question_text' => $question->question_text,
                'type' => $question->type,
                'total_answers' => $total,
                'average_score' => $average,
            ];
        });

        return view('admin.surveys.report_pdf', compact('results'));
    }
}

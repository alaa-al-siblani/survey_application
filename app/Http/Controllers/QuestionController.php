<?php

namespace App\Http\Controllers;

use App\Question;
use App\Questionnaire;

class QuestionController extends Controller
{
    public function create(Questionnaire $questionnaire)
    {
        return view('question.create', compact('questionnaire'));
    }

    public function create_normal(Questionnaire $questionnaire)
    {
        return view('question.create_normal', compact('questionnaire'));
    }

    public function store(Questionnaire $questionnaire)
    {
        $data = request()->validate([
            'question.question' => 'required',
            'answers.*.answer' => 'required',
        ]);

        $question = $questionnaire->questions()->create($data['question']);
        $question->answers()->createMany($data['answers']);

        return redirect('/questionnaires/'.$questionnaire->id);
    }

    public function store_normal(Questionnaire $questionnaire)
    {
        $data = request()->validate([
            'question.question' => 'required',
        ]);

        $question = $questionnaire->questions()->create($data['question']);
        return redirect('/questionnaires/'.$questionnaire->id);
    }

    public function destroy(Questionnaire $questionnaire, Question $question)
    {
        $question->normal_answers()->delete();
        $question->answers()->delete();
        $question->delete();

        return redirect($questionnaire->path());
        
    }
}

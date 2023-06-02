<?php

namespace App\Http\Controllers;

use App\Questionnaire;

class SurveyController extends Controller
{
    public function show(Questionnaire $questionnaire, $slug)
    {
        $questionnaire->load('questions.answers');

        return view('survey.show', compact('questionnaire'));
    }

    public function store(Questionnaire $questionnaire)
    {
        $data = request()->validate([
            'responses.*.answer_id' => 'required',
            'responses.*.question_id' => 'required',
            'survey.name' => 'required',
            'survey.email' => 'required|email',
            'normal_answer.*.answer' =>'required',
            'normal_answer.*.question_id' =>'required',
        ]);
        $survey = $questionnaire->surveys()->create($data['survey']);
        if(isset($data['normal_answer']))
        {
            $survey->normal_answers()->createMany($data['normal_answer']);
        }
        if(isset($data['responses']))
        {
             $survey->responses()->createMany($data['responses']);
        }
        return view('survey.finish');
    }
}

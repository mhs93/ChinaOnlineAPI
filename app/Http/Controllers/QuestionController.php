<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class QuestionController extends Controller
{
    public function getQuestions()
    {
        //Start API response section

        //get Access Token
        $access_token_response = Http::withHeaders([
            'email' => 'mominulhasan93@gmail.com',
        ])
            ->post('https://chinaonlinebd-code-interview.vercel.app/api/v1/get-access-token');

        $access_token = json_decode($access_token_response)->accessToken;

        //get Grant Token
        $grant_token_response = Http::withHeaders([
            'token' => $access_token,
        ])
            ->post('https://chinaonlinebd-code-interview.vercel.app/api/v1/grant-token');

        $grant_token = json_decode($grant_token_response)->grantToken;

        //get Question

        $question_response = Http::withHeaders([
            'token' => $access_token,
            'grant' => $grant_token,
        ])
            ->post('https://chinaonlinebd-code-interview.vercel.app/api/v1/get-the-question');

        $questions = json_decode($question_response)->question;

//        $sort = json_decode($question_response)->solutionResult;
//        dd($sort);
        //End API response section

        $property_name = array();
        foreach ($questions as $question) {
            $property_name['propertyName'][$question->PropertyName]['value'][] = $question->Value;
        }

//        dd($property_name);
        return $property_name;

    }
}

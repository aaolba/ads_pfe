<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use OpenAI;
class gptController extends Controller
{
    public function generateContent(request $request){
        $Brief = $request->input('Brief');
        $Brief='make a paragraph to be a content of a facebook post :'.$Brief;
        $yourApiKey = getenv('OPENAI_API_KEY');
        $client = OpenAI::client($yourApiKey);
        

        $result = $client->completions()->create([
        'model' => 'text-davinci-003',
        'prompt' => $Brief,
        'max_tokens' => 2000,
        ]);
        return $result['choices'][0]['text'];
    }
}

<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class TranslateGPT
{

    protected string $chatURL = "https://api.openai.com/v1/chat/completions";
    protected string $chatModel = "gpt-3.5-turbo";

    protected string $systemPrompt = "I will give you some general information and you have to transform that from English to Bangla or vice versa and send both results in the response as json format like {en: 'English', bn: 'Bangla'}.Keep the results consistent and spell them accurately. Information I will give you is mostly names, abbreviations,numbers,etc. But don't transform informations like email, dates,keys acronyms or abbreviations & numbers.";

    public function translate(string $text)
    {
        $key = env('OPEN_AI_KEY');
        $response = Http::withHeaders([
            "Authorization" => "Bearer $key"
        ])->post($this->chatURL, [
            'model' => $this->chatModel,
            'messages' => [
                ['role' => 'system', 'content' => $this->systemPrompt],
                ['role' => 'user', 'content' => $text]
            ]

        ]);
        $data = json_decode(json_encode([
            'response' => json_encode($response),
            'content' => json_decode($response)->choices[0]->message->content
        ]));
        return $data;
    }
}

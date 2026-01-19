<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Contracts\AiProvider;
use App\Enums\AiOutputFormat;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class Gemini
{

    protected $baseUrl;

    protected $prompt;

    protected $authKey;
    protected $context = [];
    protected $imageContext = [];
    protected $outputFormat;
    protected $identity;

    protected $response;

    protected $model = 'gemini-3-flash-preview';

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/' . $this->model . ':generateContent';
        $this->authKey = env('GEMINI_API_KEY');

        $this->outputFormat(AiOutputFormat::TEXT);
    }

    public function outputFormat(AiOutputFormat $format): static
    {
        $this->outputFormat = $format;

        if ($format == AiOutputFormat::IMAGE) {
            // $this->model = 'gemini-3-pro-image-preview';
            $this->model = 'gemini-2.5-flash-image';
            $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/' . $this->model . ':generateContent';
        }

        return $this;
    }

    public function setPrompt(string $prompt): static
    {
        $this->prompt = $prompt;

        return $this;
    }

    public function identity(string $identity): static
    {
        $this->identity = $identity;

        return $this;
    }

    public function addContext(string $type, string $context): static
    {
        $this->context[$type] = $context;

        return $this;
    }

    public function addImageContext(string $context): static
    {
        $this->imageContext[] = $context;

        return $this;
    }


    public function ask()
    {


        $prompt = '';

        $prompt .= '# Your identity:' . "\n" . $this->identity . "\n\n";

        if (!empty($this->context)) {

            $prompt .= "# Prompt Context:\n";
            foreach ($this->context as $type => $context) {
                $prompt .= '- ' . $type . ": " . $context . "\n";
            }
        }

        $prompt .= "\n# Prompt:\n" . $this->prompt .  "\n\n";

        $prompt .= '# Output Format (important):' . "\n" . $this->outputFormat->getAiPrompt() . "\n\n";

        $request = [
            'contents' => [
                [
                    'parts' => [],
                ],
            ],

        ];

        $request['contents'][0]['parts'][]['text'] = $prompt;

        if (!empty($this->imageContext)) {
            foreach ($this->imageContext as $context) {
                $request['contents'][0]['parts'][]['inline_data'] = [
                    'mime_type' => 'image/jpeg',
                    'data' => $context,
                ];
            }

            $request['generationConfig'] = [
                'imageConfig' => [
                    'aspectRatio' => '1:1',
                ]
            ];
        }

        $body = Http::timeout(120)->withHeaders([
            'Content-Type' => 'application/json',
            'X-goog-api-key' => $this->authKey,
        ])->post(
            $this->baseUrl,
            $request
        )->json();


        if ($this->outputFormat == AiOutputFormat::JSON) {

            dd($body);
            $response = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $response = trim($response);
            return json_decode($response, true);
        }

        if ($this->outputFormat == AiOutputFormat::IMAGE) {

            foreach (($body['candidates'][0]['content']['parts'] ?? []) as $part) {

                if (!empty($part['inlineData'])) {
                    return $part['inlineData']['data'];
                }
            }


            dd($body);
            return '';
        }
    }

    public function getResponse(): string
    {
        return $this->response;
    }

    public function getJsonResponse(): array
    {
        return json_decode($this->response, true);
    }
}

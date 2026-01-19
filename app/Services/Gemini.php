<?php

namespace App\Services;

use App\Contracts\AiProvider;
use App\Enums\AiOutputFormat;
use Illuminate\Support\Facades\Http;

class Gemini
{

    protected $baseUrl;

    protected $prompt;

    protected $authKey;
    protected $context = [];

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

        $body = Http::timeout(120)->withHeaders([
            'Content_Type' => 'application/json',
            'X-goog-api-key' => $this->authKey,
        ])->post(
            $this->baseUrl,
            [
                'contents' => [
                    [
                        'parts' => [
                            'text' => $prompt,
                        ],
                    ],
                ],
            ]
        )->throw()->json();

        $response = $body['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $this->response = trim($response);

        if ($this->outputFormat == AiOutputFormat::JSON) {
            return json_decode($this->response, true);
        }

        return $this;
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

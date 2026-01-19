<?php

return [

    /*
    |--------------------------------------------------------------------------
    | AI Provider Configuration
    |--------------------------------------------------------------------------
    |
    | This file allows you to configure which AI provider implementation
    | should be used throughout the application. You can switch providers
    | by changing the 'provider' value or setting the AI_PROVIDER environment
    | variable.
    |
    */

    'provider' => env('AI_PROVIDER', 'gemini'),

    /*
    |--------------------------------------------------------------------------
    | Provider Class Mapping
    |--------------------------------------------------------------------------
    |
    | Maps provider names to their fully qualified class names.
    | Add new providers here when implementing additional AI services.
    |
    */

    'providers' => [
        'gemini' => \App\Services\Gemini::class,
        // Add more providers here as needed:
        // 'openai' => \App\Integrations\AiProviders\OpenAI::class,
        // 'anthropic' => \App\Integrations\AiProviders\Anthropic::class,
    ],

];

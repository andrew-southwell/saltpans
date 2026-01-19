<?php

namespace App\Enums;

enum AiOutputFormat: string
{
    case JSON = 'json';
    case TEXT = 'text';
    case HTML = 'html';
    case MARKDOWN = 'markdown';
    case CSV = 'csv';
    case SQL = 'sql';

    public function getAiPrompt(): string
    {
        return match ($this) {
            self::JSON => 'Please return the response in JSON format. Do not include thinking or any additional information not requested. ',
            self::TEXT => 'Please return the response in text format.',
            self::HTML => 'Please return the response in HTML format.',
            self::MARKDOWN => 'Please return the response in markdown format.',
            self::CSV => 'Please return the response in CSV format.',
            self::SQL => 'Please return the response in SQL format.',
        };
    }
}

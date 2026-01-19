<?php

namespace App\Actions;

use Spatie\PdfToText\Pdf;

class PdfToText
{
    public static function handle(string $pdfPath)
    {

        $text = (new Pdf())
            ->setPdf($pdfPath)
            ->text();

        dd($text);
        return $text;
    }
}

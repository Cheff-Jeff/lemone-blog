<?php

namespace PHP\Helpers;

class SanitizeHTML
{
    public static function outputCleanHTML(string $html): string
    {
        return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    }
}
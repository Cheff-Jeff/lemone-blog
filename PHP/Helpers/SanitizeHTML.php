<?php

namespace PHP\Helpers;

use HTMLPurifier;
use HTMLPurifier_Config;

class SanitizeHTML
{
    public static function outputCleanHTML(string $html): string
    {
        return htmlspecialchars($html, ENT_QUOTES, 'UTF-8');
    }

    public static function cleanWYSIWYGInput(string $html): string
    {
        $config = HTMLPurifier_Config::createDefault();

        $config->set('HTML.Allowed', '
            h2,h3,h4,h5,h6,
            strong,em,u,s,
            blockquote,
            ol,ul,li,
            a[href],
            span[style]
        ');

        $config->set('CSS.AllowedProperties', ['color', 'background-color']);
        $config->set('Attr.AllowedFrameTargets', ['_blank']);
        $config->set('HTML.SafeIframe', false);
        $config->set('URI.SafeIframeRegexp', '');

        $purifier = new HTMLPurifier($config);
        $clean = $purifier->purify($html);

        return preg_replace('/\x{00A0}/u', ' ', $clean);
    }
}
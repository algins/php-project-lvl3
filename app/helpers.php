<?php

if (! function_exists('normalize_url')) {
    function normalize_url(string $url): string
    {
        /** @var string $parsedUrl */
        $parsedUrl = parse_url($url, PHP_URL_HOST);

        return strtolower($parsedUrl);
    }
}

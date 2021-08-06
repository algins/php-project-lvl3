<?php

if (! function_exists('normalize_url')) {
    function normalize_url(string $url): string
    {
        return strtolower(parse_url($url, PHP_URL_HOST));
    }
}

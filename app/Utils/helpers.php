<?php

if (!function_exists('convertFileToArray')) {
    function convertFileToArray(string $path): array
    {
        return json_decode(file_get_contents(base_path($path)), true);
    }
}

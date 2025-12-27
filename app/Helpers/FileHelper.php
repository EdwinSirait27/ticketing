<?php

if (!function_exists('safeFolder')) {
    function safeFolder(string $name): string
    {
        return preg_replace('/[^A-Za-z0-9_\-]/', '_', $name);
    }
}

<?php
// helpers.php

if (!function_exists('assets')) {
    function assets($path)
    {
        return '/assets/' . $path;
    }
}

if (!function_exists('components')) {
    function components($component)
    {
        return __DIR__ . '/components/' . $component . '/index.php';
    }
}

<?php
// helpers.php

/**
 * Checks if the 'assets' function does not already exist, and if not, defines it.
 * 
 * @param string $path The path to the asset file.
 * @return string The full URL to the asset file.
 */
if (!function_exists('assets')) {
    function assets($path)
    {
        return '/todo-list-bhaknus/assets/' . $path;
    }
}

/**
 * Checks if the 'components' function does not already exist, and if not, defines it.
 * 
 * @param string $component The name of the component.
 * @return string The full file path to the component's index.php file.
 */
if (!function_exists('components')) {
    function components($component)
    {
        return __DIR__ . '/../../components/' . $component . '/index.php';
    }
}

/**
 * Checks if the 'url' function does not already exist, and if not, defines it.
 * 
 * @param string $path The path to the URL.
 * @return string The full URL to the path.
 */
if (!function_exists('url')) {
    function url($path)
    {
        return '/todo-list-bhaknus/' . $path;
    }
}

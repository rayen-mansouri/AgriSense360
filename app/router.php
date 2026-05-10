<?php
/**
 * Symfony Router for PHP Built-in Server
 * Handles routing to public/index.php for all non-static requests
 */
$file = __DIR__ . '/public' . $_SERVER['REQUEST_URI'];

// If it's a real file or directory, serve it
if (is_file($file) || is_dir($file)) {
    return false;
}

// Otherwise, route to Symfony's index.php
require __DIR__ . '/public/index.php';

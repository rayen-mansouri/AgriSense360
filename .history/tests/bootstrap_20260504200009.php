<?php
// tests/bootstrap.php
use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

// Load environment variables for test environment
if (file_exists(dirname(__DIR__).'/.env.test')) {
    (new Dotenv())->load(dirname(__DIR__).'/.env.test');
}

// Ensure Kernel class exists
if (!class_exists(App\Kernel::class)) {
    throw new \RuntimeException('Kernel class not found. Make sure your App\Kernel class exists.');
}
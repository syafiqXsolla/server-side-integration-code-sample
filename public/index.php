<?php

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

$url = parse_url($_SERVER['REQUEST_URI']);

if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

// Check if the request is for the webhook
if ($url['path'] === '/webhook') {
    require __DIR__ . '/webhook.php';
    exit();
}

// Handle PayStation interactions
require __DIR__ . '/../view/main-page.php';

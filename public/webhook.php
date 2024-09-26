<?php

use App\Helpers\Env;
use App\Webhook\WebhookHandler;
use Dotenv\Dotenv;
use Xsolla\SDK\Exception\Webhook\InvalidSignatureException;

// Load environment variables
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$secretKey = Env::get('XSOLLA_WEBHOOK_SECRET_KEY');

try {
    // Get the message and verify signature
    $message = WebhookHandler::getMessage($secretKey);
} catch (InvalidSignatureException $e) {
    http_response_code(400);
    echo '{"error": {"code": "INVALID_SIGNATURE","message": "Invalid signature"}}';
    exit();
}

// Process the webhook message
list($body, $code) = WebhookHandler::handle($message);
http_response_code($code);
echo $body;

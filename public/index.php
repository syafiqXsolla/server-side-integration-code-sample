<?php

use App\Helpers\Env;
use App\Webhook\WebhookHandler;
use Dotenv\Dotenv;
use Xsolla\SDK\Exception\Webhook\InvalidSignatureException;

$url = parse_url($_SERVER['REQUEST_URI']);

if (PHP_SAPI === 'cli-server') {
    $file = __DIR__ . $url['path'];
    if (is_file($file)) return false;
}

require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

if ($url['path'] === '/webhook') {

    $secretKey = Env::get('XSOLLA_WEBHOOK_SECRET_KEY');
    try {
        $message = WebhookHandler::getMessage($secretKey);
    } catch (InvalidSignatureException $e) {
        http_response_code(400);
        echo '{"error": {"code": "INVALID_SIGNATURE","message": "Invalid signature"}}';
        exit();
    }

    list($body, $code) = WebhookHandler::handle($message);
    http_response_code($code);
    echo $body;
    return;
}

require __DIR__ . '/../view/main-page.php';
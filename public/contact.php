<?php
// Autoload dependencies
require_once __DIR__ . '/../vendor/autoload.php';
use Config\MailConfig;
use Dotenv\Dotenv;
use App\Http\Controllers\ContactController;
// Start session
session_start();
// Check if running on Heroku
$isHeroku = isset($_ENV['DYNO']);
// Load environment variables from .env file if not on Heroku
if (!$isHeroku) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}
// Initialize mail configuration
MailConfig::init();
// Handle contact form submission
$controller = new ContactController();
$controller->handle();

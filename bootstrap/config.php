<?php
// Autoload dependencies
require_once __DIR__ . '/../vendor/autoload.php';
use Dotenv\Dotenv;
// Check if running on Heroku
$isHeroku = isset($_ENV['DYNO']);
// Load environment variables from .env file if not on Heroku
if (!$isHeroku) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
    $dotenv->load();
}
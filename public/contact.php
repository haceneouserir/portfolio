<?php
// Bootstrap the application
require __DIR__ . '/../bootstrap/config.php';
use Config\MailConfig;
use App\Http\Controllers\ContactController;
// Start session
session_start();
// Initialize mail configuration
MailConfig::init();
// Handle contact form submission
$controller = new ContactController();
$controller->handle();

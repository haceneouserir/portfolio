<?php

namespace App\Http\Controllers;

use App\Http\Middleware\VerifyCsrfToken;
use App\Rules\TurnstileRule;
use App\Http\Requests\ContactRequest;
use App\Mail\ContactMailer;
use App\Support\JsonResponse;
use Config\MailConfig;

class ContactController
{
  public function handle(): void
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      JsonResponse::send([
        'success' => false,
        'message' => 'Something went wrong. Please try again!'
      ], 405);
    }

    $csrf = new VerifyCsrfToken();
    if (!$csrf->validate(
      $_POST['csrf_token'] ?? null,
      $_SESSION['csrf_token'] ?? null
    )) {
      JsonResponse::send([
        'success' => false,
        'message' => 'Something went wrong. Please try again!'
      ], 403);
    }

    $validator = new ContactRequest();
    [$errors, $data] = $validator->validate($_POST);

    $turnstile = new TurnstileRule(MailConfig::$TURNSTILE_SECRET_KEY);
    if (!$turnstile->verify(
      $_POST['cf-turnstile-response'] ?? null,
      $_SERVER['REMOTE_ADDR'] ?? null
    )) {
      $errors['cf-turnstile-response'] = 'Please verify that you are not a robot!';
    }
    if ($errors) {
      JsonResponse::send([
        'success' => false,
        'errors' => $errors
      ], 422);
    }

    $mailer = new ContactMailer();
    if (!$mailer->send($data)) {
      JsonResponse::send([
        'success' => false,
        'message' => 'Your message has not been sent!'
      ], 500);
    }

    JsonResponse::send([
      'success' => true,
      'message' => 'Your message has been sent successfully!'
    ]);
  }
}

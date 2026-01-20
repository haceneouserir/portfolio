<?php

namespace App\Http\Requests;

use App\Traits\Sanitizer;
use ElliotJReed\DisposableEmail\DisposableEmail;

class ContactRequest
{
  use Sanitizer;

  public function validate(array $input): array
  {
    $errors = [];
    // Validate input fields
    $name = $this->sanitize($input['name'] ?? '');
    $email = $this->sanitize($input['email'] ?? '');
    $subject = $this->sanitize($input['subject'] ?? '');
    $message = $this->sanitize($input['message'] ?? '');

    // Name validation
    if (empty($name)) {
      $errors['name'] = "The full name field is required!";
    } else if (strlen($name) > 30) {
      $errors['name'] = "The full name is greater than 30 characters!";
    }

    // Email validation
    if (empty($email)) {
      $errors['email'] = "The email field is required!";
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL) || DisposableEmail::isDisposable($email)) {
      $errors['email'] = "Invalid email address!";
    } 
    // Subject validation
    if (empty($subject)) {
      $errors['subject'] = "The subject field is required!";
    } elseif (strlen($subject) > 50) {
      $errors['subject'] = "The subject is greater than 50 characters!";
    } 
    // Message validation
    if (empty($message)) {
      $errors['message'] = "The message field is required!";
    } elseif (strlen($message) > 500) {
      $errors['message'] = "The message is greater than 500 characters!";
    }

    return [$errors, compact('name', 'email', 'subject', 'message')];
  }
}

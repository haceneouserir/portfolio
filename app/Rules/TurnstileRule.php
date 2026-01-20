<?php

namespace App\Rules;

class TurnstileRule
{
  private string $secretKey;
  public function __construct(string $secretKey) {
    $this->secretKey = $secretKey;
  }

  public function verify(?string $response, ?string $ip): bool {
    if (empty($response)) {
      return false;
    }

    $context = stream_context_create([
      'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/x-www-form-urlencoded\r\n",
        'content' => http_build_query([
          'secret'   => $this->secretKey,
          'response' => $response,
          'remoteip' => $ip,
        ]),
      ]
    ]);

    $result = file_get_contents(
      'https://challenges.cloudflare.com/turnstile/v0/siteverify',
      false,
      $context
    );

    if (!$result) {
      return false;
    }

    $json = json_decode($result, true);
    return !empty($json['success']);
  }
}

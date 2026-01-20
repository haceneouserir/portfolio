<?php

namespace App\Http\Middleware;

class VerifyCsrfToken
{
    public function validate(?string $formToken, ?string $sessionToken): bool
    {
      if (!$formToken || !$sessionToken) {
          return false;
      }

      return hash_equals($sessionToken, $formToken);
    }
}
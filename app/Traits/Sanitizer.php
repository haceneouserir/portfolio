<?php

namespace App\Traits;

trait Sanitizer
{
  protected function sanitize(string $value): string
  {
    return htmlspecialchars(
      stripslashes(
        trim($value)
      ),
      ENT_QUOTES,
      'UTF-8'
    );
  }
}

<?php

namespace App\Support;

class JsonResponse
{
  public static function send(array $data, int $status = 200): void
  {
    http_response_code($status);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
  }
}

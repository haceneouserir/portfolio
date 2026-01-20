<?php

namespace App\Mail\Contracts;

interface MailerInterface
{
    public function send(array $data): bool;
}
<?php

namespace App\Mail;

use App\Mail\Abstracts\AbstractMailer;
use Config\MailConfig;

class ContactMailer extends AbstractMailer
{
  public function send(array $data): bool
  {
    $this->mail->addAddress(MailConfig::$MAIL_ADDRESS);
    $this->mail->addReplyTo($data['email'], $data['name']);
    $this->mail->Subject = $data['subject'];
    $this->mail->Body = $data['message'];
    return $this->mail->send();
  }
}

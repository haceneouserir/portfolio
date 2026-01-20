<?php
namespace App\Mail\Abstracts;

use PHPMailer\PHPMailer\PHPMailer;
use App\Mail\Contracts\MailerInterface;
use Config\MailConfig;

abstract class AbstractMailer implements MailerInterface
{
  protected PHPMailer $mail;

  public function __construct() {
    $this->mail = new PHPMailer(true);
    $this->mail->SMTPDebug = MailConfig::SMTP_DEBUG;
    $this->mail->isSMTP();
    $this->mail->Host = MailConfig::$SMTP_HOST;
    $this->mail->SMTPAuth = true;
    $this->mail->Username = MailConfig::$SMTP_USERNAME;
    $this->mail->Password = MailConfig::$SMTP_PASSWORD;
    $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $this->mail->Port = MailConfig::$SMTP_PORT;

    $this->mail->setFrom(
      MailConfig::$MAIL_FROM,
      MailConfig::$MAIL_FROM_NAME
    );

    $this->mail->isHTML(true);
  }
}
<?php
require_once __DIR__.'/../config/env.php';

function clean($v){ return trim(filter_var($v, FILTER_SANITIZE_FULL_SPECIAL_CHARS)); }

$name    = clean($_POST['name'] ?? '');
$email   = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL);
$message = clean($_POST['message'] ?? '');

if(!$name || !$email || !$message){
  http_response_code(400);
  exit('Datos inválidos');
}

$subject = "Contacto web - Tera Software";
$bodyTxt = "Nombre: {$name}\nEmail: {$email}\n\nMensaje:\n{$message}\n";

// --- Intento con PHPMailer (si está disponible) ---
$sent = false;
if (class_exists('\PHPMailer\PHPMailer\PHPMailer')) {
  try {
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    // SMTP si hay host definido
    if (defined('SMTP_HOST') && SMTP_HOST) {
      $mail->isSMTP();
      $mail->Host       = SMTP_HOST;
      $mail->Port       = SMTP_PORT;
      $mail->SMTPAuth   = true;
      $mail->Username   = SMTP_USER;
      $mail->Password   = SMTP_PASS;
      if (SMTP_SECURE) { $mail->SMTPSecure = SMTP_SECURE; }
    }

    $mail->CharSet = 'UTF-8';
    $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
    $mail->addAddress(MAIL_TO);
    $mail->addReplyTo($email, $name);
    $mail->Subject = $subject;
    $mail->Body    = $bodyTxt;
    $mail->AltBody = $bodyTxt;

    $sent = $mail->send();
  } catch (Throwable $e) {
    $sent = false; // caerá al fallback
  }
}

// --- Fallback: mail() nativo ---
if (!$sent) {
  $headers = "From: ".MAIL_FROM."\r\nReply-To: {$email}\r\nContent-Type: text/plain; charset=UTF-8";
  @mail(MAIL_TO, $subject, $bodyTxt, $headers);
}

// Volver a la página con ok
header('Location: /contacto.php?ok=1');

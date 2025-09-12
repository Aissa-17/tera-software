<?php
define('MAIL_TO', 'contacto@tera-software.com');
// Datos remitente (From)
define('MAIL_FROM', 'no-reply@tu-dominio.test');
define('MAIL_FROM_NAME', 'Tera Software');

// SMTP (si no usas SMTP, deja HOST vacío y hará fallback a mail())
define('SMTP_HOST', 'smtp.tu-proveedor.com');   // ej: smtp.gmail.com
define('SMTP_PORT', 587);                       // 465 (ssl) o 587 (tls)
define('SMTP_USER', 'usuario@tu-dominio.com');
define('SMTP_PASS', 'tu_password');
define('SMTP_SECURE', 'tls');                   // 'ssl' o 'tls'

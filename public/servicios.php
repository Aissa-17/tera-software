<?php
// Autoload de Composer si existe
$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($autoload)) { require_once $autoload; }

$title = 'Servicios — Tera Software';
ob_start();

include __DIR__.'/../includes/bloques/servicios.php';
include __DIR__.'/../includes/bloques/contacto-cta.php';

$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

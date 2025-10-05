<?php
// Autoload de Composer si existe
$autoload = dirname(__DIR__) . '/vendor/autoload.php';
if (file_exists($autoload)) { require_once $autoload; }

// public/index.php
$title = 'Tera Software — UX & desarrollo para B2B';
ob_start();

// Bloques (se pueden reordenar o comentar)
include __DIR__ . '/../includes/bloques/portada.php';
include __DIR__ . '/../includes/bloques/tecnologias.php';
include __DIR__ . '/../includes/bloques/industrias.php';
include __DIR__ . '/../includes/bloques/razones.php';
include __DIR__.'/../includes/bloques/faq.php';

$content = ob_get_clean();
include __DIR__ . '/../includes/layout.php';

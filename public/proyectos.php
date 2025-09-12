<?php
$title = 'Proyectos — Tera Software';
ob_start();

include __DIR__.'/../includes/bloques/proyectos.php';
include __DIR__.'/../includes/bloques/contacto-cta.php';

$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

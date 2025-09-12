<?php
$title = 'Nosotros — Tera Software';
ob_start();

include __DIR__.'/../includes/bloques/nosotros-hero.php';
include __DIR__.'/../includes/bloques/valores.php';
include __DIR__.'/../includes/bloques/metodo.php';
include __DIR__.'/../includes/bloques/equipo.php';
include __DIR__.'/../includes/bloques/herramientas.php';
include __DIR__.'/../includes/bloques/contacto-cta.php';

$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

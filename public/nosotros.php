<?php
$title = 'Nosotros — Tera Software';
ob_start();

// HERO + misión/impacto
include __DIR__.'/../includes/bloques/nosotros-hero.php';
include __DIR__.'/../includes/bloques/nosotros-mision.php';

// Valores (puedes usar el tuyo o el de abajo)
include __DIR__.'/../includes/bloques/valores.php';

// Equipo (tu include actual)
include __DIR__.'/../includes/bloques/equipo.php';

// Historia / Timeline (nacidos en 2025)
include __DIR__.'/../includes/bloques/nosotros-historia.php';

// CTA final
include __DIR__.'/../includes/bloques/contacto-cta.php';

$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

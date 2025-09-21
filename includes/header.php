<?php
// includes/header.php

// Ruta actual para marcar activo en el menú
$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
function active($p){ global $path; return $path === $p ? ' is-active' : ''; }

// Idiomas disponibles (etiquetas para el desplegable)
$langs = [
  'es' => ['label' => 'Español'],
  'en' => ['label' => 'English'],
  'fr' => ['label' => 'Français'],
  'de' => ['label' => 'Deutsch'],
];
$current = $langs[defined('LANG') ? LANG : 'es'] ?? $langs['es'];

// Iconos de banderas (SVG ligeros, sin dependencias)
function flag_svg($code, $size = 18){
  $w = round($size * 4/3, 2);
  switch ($code) {
    case 'es': // España
      return '<svg width="'.$w.'" height="'.$size.'" viewBox="0 0 4 3" aria-hidden="true">
        <rect width="4" height="3" fill="#AA151B"/>
        <rect y="1" width="4" height="1" fill="#F1BF00"/>
      </svg>';
    case 'en': // UK simplificado
      return '<svg width="'.$w.'" height="'.$size.'" viewBox="0 0 4 3" aria-hidden="true">
        <rect width="4" height="3" fill="#012169"/>
        <path d="M0,0 L4,3 M4,0 L0,3" stroke="#FFF" stroke-width="0.6"/>
        <path d="M0,0 L4,3 M4,0 L0,3" stroke="#C8102E" stroke-width="0.3"/>
        <rect x="1.7" width="0.6" height="3" fill="#FFF"/>
        <rect y="1.2" width="4" height="0.6" fill="#FFF"/>
        <rect x="1.85" width="0.3" height="3" fill="#C8102E"/>
        <rect y="1.35" width="4" height="0.3" fill="#C8102E"/>
      </svg>';
    case 'fr': // Francia
      return '<svg width="'.$w.'" height="'.$size.'" viewBox="0 0 3 2" aria-hidden="true">
        <rect width="1" height="2" x="0" fill="#0055A4"/>
        <rect width="1" height="2" x="1" fill="#FFF"/>
        <rect width="1" height="2" x="2" fill="#EF4135"/>
      </svg>';
    case 'de': // Alemania
      return '<svg width="'.$w.'" height="'.$size.'" viewBox="0 0 5 3" aria-hidden="true">
        <rect width="5" height="1" y="0" fill="#000"/>
        <rect width="5" height="1" y="1" fill="#DD0000"/>
        <rect width="5" height="1" y="2" fill="#FFCE00"/>
      </svg>';
    default:
      return '<svg width="'.$w.'" height="'.$size.'" viewBox="0 0 1 1" aria-hidden="true"><rect width="1" height="1" fill="#888"/></svg>';
  }
}

// Icono simple para contraste
function contrast_icon($level = 'normal', $size = 16){
  $text = ($level === 'high') ? 'A↑' : (($level === 'max') ? 'A++' : 'A');
  $fs = round($size * 0.72, 2);
  return '<span class="ci" style="width:'.$size.'px;height:'.$size.'px;display:inline-flex;align-items:center;justify-content:center;font:600 '.$fs.'px/1 Inter,system-ui,sans-serif">'.$text.'</span>';
}
?>
<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="/">
      <img src="/assets/img/brand/tera-logo-neon.png" alt="Tera Software" width="28" height="28" />
      <span>Tera Software</span>
    </a>

    <nav class="nav">
      <a class="<?= active('/servicios.php') ?>" href="/servicios.php"><?= __t('nav.services') ?></a>
      <a class="<?= active('/proyectos.php') ?>" href="/proyectos.php"><?= __t('nav.projects') ?></a>
      <a class="<?= active('/nosotros.php')  ?>" href="/nosotros.php"><?= __t('nav.about') ?></a>
      <a class="nav-cta<?= active('/contacto.php') ?>" href="/contacto.php"><?= __t('nav.contact') ?></a>

      <!-- ===== Selector de idioma ===== -->
      <div class="lang-dropdown">
        <button class="lang-btn" type="button" aria-haspopup="listbox" aria-expanded="false" aria-label="<?= htmlspecialchars(__t('nav.language')) ?>">
          <span class="flag"><?= flag_svg(defined('LANG') ? LANG : 'es', 16) ?></span>
          <span class="lang-label"><?= htmlspecialchars($current['label']) ?></span>
          <svg class="chev" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg>
        </button>
        <ul class="lang-menu" role="listbox">
          <?php foreach ($langs as $code => $meta): ?>
            <li role="option">
              <a href="<?= i18n_switch_link($code) ?>" data-lang="<?= $code ?>" aria-selected="<?= (defined('LANG') && LANG===$code) ? 'true' : 'false' ?>">
                <span class="flag"><?= flag_svg($code, 14) ?></span>
                <span><?= htmlspecialchars($meta['label']) ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
      <!-- ===== /Selector de idioma ===== -->

      <!-- ===== Selector de contraste ===== -->
      <div class="contrast-dropdown">
        <button class="contrast-btn" type="button" aria-haspopup="listbox" aria-expanded="false">
          <?= contrast_icon('normal', 14) ?>
          <span class="contrast-label"><?= __t('contrast.label') ?></span>
          <svg class="chev" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true"><path d="M7 10l5 5 5-5" fill="none" stroke="currentColor" stroke-width="2"/></svg>
        </button>
        <ul class="contrast-menu" role="listbox">
          <li role="option"><a href="#" data-contrast="normal" aria-selected="true"><?= contrast_icon('normal', 12) ?> <span><?= __t('contrast.normal') ?></span></a></li>
          <li role="option"><a href="#" data-contrast="high"><?= contrast_icon('high', 12) ?> <span><?= __t('contrast.high') ?></span></a></li>
          <li role="option"><a href="#" data-contrast="max"><?= contrast_icon('max', 12) ?> <span><?= __t('contrast.max') ?></span></a></li>
        </ul>
      </div>
      <!-- ===== /Selector de contraste ===== -->
    </nav>
  </div>
</header>

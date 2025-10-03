<?php
// includes/layout.php

// 0) Carga i18n antes de cualquier salida HTML
$__i18n = __DIR__ . '/i18n.php';
if (file_exists($__i18n)) {
    require_once $__i18n;
}

// 1) Fallbacks seguros si i18n.php no está (evita fatals)
if (!defined('LANG')) {
    define('LANG', 'es');
}
if (!function_exists('__t')) {
    function __t(string $key, array $repl = []) : string {
        // Devuelve la clave tal cual como degradación
        return $key;
    }
}
if (!function_exists('i18n_alternates')) {
    function i18n_alternates() : void {
        // No-op si no hay i18n real cargado
    }
}
if (!function_exists('i18n_switch_link')) {
    function i18n_switch_link(string $targetLang) : string {
        $path = strtok($_SERVER['REQUEST_URI'] ?? '/', '?') ?: '/';
        return $path . '?lang=' . urlencode($targetLang);
    }
}

// 2) Título por defecto
if (!isset($title)) { $title = 'Tera Software — Agencia tecnológica'; }
?>
<!doctype html>
<html lang="<?= LANG ?>">
<head>
  <?php i18n_alternates(); ?>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= htmlspecialchars($title) ?></title>
  <meta name="description" content="Diseño y desarrollo de software B2B. UX, frontend, backend y cloud." />
  <link rel="icon" type="image/png" sizes="32x32" href="/assets/img/brand/favicon-32.png">
  <link rel="apple-touch-icon" sizes="180x180" href="/assets/img/brand/apple-touch-icon.png">
  <link rel="icon" type="image/svg+xml" href="/assets/img/brand/favicon.svg">
  <meta name="theme-color" content="#0d0f12">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body class="theme-dark">
  <?php include __DIR__ . '/header.php'; ?>

  <main id="contenido">
    <?= $content ?? '' ?>
  </main>

  <?php include __DIR__ . '/footer.php'; ?>
  <script src="/assets/js/main.js" defer></script>
</body>
</html>

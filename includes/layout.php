<?php
// includes/layout.php
if (!isset($title)) { $title = 'Tera Software — Agencia tecnológica'; }
?>
<!doctype html>
<html lang="es">
<head>
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
<?php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
function active($p){ global $path; return $path === $p ? ' is-active' : ''; }
?>

<header class="site-header">
  <div class="container header-inner">
    <a class="brand" href="/">
  <img src="/assets/img/brand/tera-logo-neon.png" alt="Tera Software" width="28" height="28" />
  <span>Tera Software</span>
</a>
  
<nav class="nav">
  <a class="<?= active('/servicios.php') ?>" href="/servicios.php">Servicios</a>
  <a class="<?= active('/proyectos.php') ?>" href="/proyectos.php">Proyectos</a>
  <a class="<?= active('/nosotros.php')  ?>" href="/nosotros.php">Nosotros</a>
  <a class="nav-cta<?= active('/contacto.php') ?>" href="/contacto.php">Contacto</a>
</nav>
  </div>
</header>
<?php
/**
 * i18n bootstrap: ES (default), EN, FR, DE
 * - Prioridad: ?lang= → cookie → Accept-Language → 'es'
 * - Guarda cookie 1 año y limpia la URL (redirige sin ?lang=)
 * - Carga diccionario base (es.php) y lo sobrescribe con el de LANG
 * - Helpers: __t(), i18n_switch_link(), i18n_alternates()
 */

$ALLOWED = ['es','en','fr','de'];
$DEFAULT = 'es';

function i18n_best_from_accept($header, $allowed, $fallback) {
  if (!$header) return $fallback;
  foreach (explode(',', $header) as $part) {
    $code = strtolower(trim(explode(';', $part)[0] ?? ''));
    $short = substr($code, 0, 2);
    if (in_array($short, $allowed, true)) return $short;
  }
  return $fallback;
}

$lang = $DEFAULT;

if (isset($_GET['lang']) && in_array($_GET['lang'], $ALLOWED, true)) {
  $lang = $_GET['lang'];
  setcookie('lang', $lang, [
    'expires'  => time() + 60*60*24*365,
    'path'     => '/',
    'secure'   => !empty($_SERVER['HTTPS']),
    'httponly' => false,
    'samesite' => 'Lax',
  ]);

  // Limpia la URL para no propagar ?lang=
  if (!headers_sent()) {
    $uri  = $_SERVER['REQUEST_URI'];
    $url  = parse_url($uri);
    $qs   = [];
    if (!empty($url['query'])) parse_str($url['query'], $qs);
    unset($qs['lang']);
    $clean = ($url['path'] ?? '/') . ($qs ? ('?' . http_build_query($qs)) : '');
    header("Location: {$clean}", true, 302);
    exit;
  }
} elseif (isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], $ALLOWED, true)) {
  $lang = $_COOKIE['lang'];
} else {
  $lang = i18n_best_from_accept($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? '', $ALLOWED, $DEFAULT);
}

if (!defined('LANG')) define('LANG', $lang);

// Cargar diccionarios
$root         = dirname(__DIR__);
$dictDefault  = $root . '/i18n/' . $DEFAULT . '.php';
$dictLangPath = $root . '/i18n/' . LANG . '.php';
$I18N         = file_exists($dictDefault) ? include $dictDefault : [];
if (LANG !== $DEFAULT && file_exists($dictLangPath)) {
  // lang sobreescribe a es
  $I18N = array_replace_recursive($I18N, include $dictLangPath);
}

/**
 * Traducción con placeholders: __t('home.hero', ['name'=>'Aissa'])
 */
function __t(string $key, array $repl = []) : string {
  global $I18N;
  $text = $I18N[$key] ?? $key;
  foreach ($repl as $k => $v) {
    $text = str_replace('{' . $k . '}', (string)$v, $text);
  }
  return $text;
}

/** Enlace para “cambiar idioma” manteniendo la ruta actual (añade ?lang=xx) */
function i18n_switch_link(string $targetLang) : string {
  $path = strtok($_SERVER['REQUEST_URI'], '?') ?: '/';
  return $path . '?lang=' . urlencode($targetLang);
}

/** <link rel="alternate" hreflang="…"> para SEO */
function i18n_alternates() : void {
  $langs = ['es','en','fr','de'];
  $scheme = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
  $host = $scheme . $_SERVER['HTTP_HOST'];
  $path = strtok($_SERVER['REQUEST_URI'], '?') ?: '/';
  foreach ($langs as $l) {
    echo '<link rel="alternate" hreflang="'.$l.'" href="'.$host.$path.'?lang='.$l.'">' . "\n";
  }
  echo '<link rel="alternate" hreflang="x-default" href="'.$host.$path.'">' . "\n";
}

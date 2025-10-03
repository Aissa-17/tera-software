<?php
$title = 'Política de Privacidad — Tera Software';
ob_start();
?>
<section class="bloque">
  <div class="container">
    <h1>Política de Privacidad</h1>
    <p>
      En <strong>Tera Software</strong> valoramos la privacidad de nuestros usuarios. 
      Esta política explica qué datos recopilamos, cómo los usamos y cuáles son tus derechos.
    </p>

    <h2>Datos que recopilamos</h2>
    <ul>
      <li>Datos de contacto enviados a través del formulario (nombre, email, mensaje).</li>
      <li>Información técnica básica para estadísticas (cookies de sesión, logs de servidor).</li>
    </ul>

    <h2>Uso de los datos</h2>
    <p>
      Los datos se utilizan únicamente para responder consultas y mejorar nuestros servicios. 
      No vendemos ni compartimos tu información con terceros.
    </p>

    <h2>Tus derechos</h2>
    <p>
      Puedes solicitar acceso, rectificación o eliminación de tus datos escribiendo a 
      <a href="mailto:info@tu-dominio.com">info@tu-dominio.com</a>.
    </p>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

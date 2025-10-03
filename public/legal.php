<?php
$title = 'Aviso Legal — Tera Software';
ob_start();
?>
<section class="bloque">
  <div class="container">
    <h1>Aviso Legal</h1>

    <h2>Información de la empresa</h2>
    <p>
      <strong>Tera Software</strong><br>
      Agencia de desarrollo y consultoría tecnológica.<br>
      Email: <a href="mailto:info@tu-dominio.com">info@tu-dominio.com</a><br>
      Dirección: Madrid, España
    </p>

    <h2>Condiciones de uso</h2>
    <p>
      El acceso a este sitio implica la aceptación de estas condiciones. 
      Los contenidos están destinados a proporcionar información general sobre nuestros servicios.
    </p>

    <h2>Propiedad intelectual</h2>
    <p>
      Todos los textos, imágenes y logotipos de este sitio son propiedad de Tera Software, 
      salvo que se indique lo contrario. Queda prohibida su reproducción sin autorización.
    </p>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

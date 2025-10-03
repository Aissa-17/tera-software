<?php
$title = 'Contacto — Tera Software';
$sent = isset($_GET['ok']);
ob_start();
?>
<section class="bloque">
  <div class="container contact-grid">
    <!-- Columna izquierda: formulario -->
    <div class="contact-form">
      <h2>Contacto</h2>
      <?php if ($sent): ?>
        <div class="card"><strong>¡Gracias!</strong> Hemos recibido tu mensaje y te responderemos pronto.</div>
      <?php else: ?>
        <form class="card" action="/forms/contact.php" method="post" style="display:grid;gap:12px;max-width:560px">
          <label>Nombre
            <input required name="name" type="text" />
          </label>
          <label>Email
            <input required name="email" type="email" />
          </label>
          <label>Mensaje
            <textarea required name="message" rows="5"></textarea>
          </label>
          <button class="btn btn-primary" type="submit">Enviar</button>
        </form>
      <?php endif; ?>
    </div>

    <!-- Columna derecha: globo animado -->
    <div class="contact-visual" aria-hidden="true">
      <canvas id="globe-canvas"></canvas>
      <div class="globe-fallback">
        <div class="chip">Soporte global</div>
        <div class="chip">Respuesta &lt; 24h</div>
      </div>
    </div>
  </div>
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

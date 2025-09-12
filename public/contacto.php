<?php
$title = 'Contacto — Tera Software';
$sent = isset($_GET['ok']);
ob_start();
?>
<section class="bloque">
  <div class="container">
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
</section>
<?php
$content = ob_get_clean();
include __DIR__.'/../includes/layout.php';

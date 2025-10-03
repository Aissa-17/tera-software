<section class="bloque tecnologias">
  <div class="container">
    <p class="eyebrow reveal reveal-up">Tecnologías que usamos</p>
  </div>

  <div class="marquee reveal reveal-zoom">
    <ul class="marquee__track">
      <?php
      $tech = [
        ['react',       'React'],
        ['nextjs',      'Next.js'],
        ['nodejs',      'Node.js'],
        ['typescript',  'TypeScript'],
        ['php',         'PHP'],
        ['wordpress',   'WordPress'],
        ['woocommerce', 'WooCommerce'],
        ['mysql',       'MySQL'],
        ['postgresql',  'PostgreSQL'],
        ['docker',      'Docker'],
        ['nginx',       'Nginx'],
        ['aws',         'AWS'],
        ['cloudflare',  'Cloudflare'],
        ['vite',        'Vite'],
        ['tailwind',    'Tailwind'],
      ];
      // Pintamos 2 veces para que la animación sea continua
      for ($k=0; $k<2; $k++):
        foreach ($tech as [$slug, $label]): ?>
          <li class="chip-tech has-mask" style="--icon:url('/assets/img/tech/<?= $slug ?>.svg')">
            <span class="ic-mask" aria-hidden="true"></span>
            <span><?= htmlspecialchars($label) ?></span>
          </li>
      <?php endforeach; endfor; ?>
    </ul>
  </div>
</section>

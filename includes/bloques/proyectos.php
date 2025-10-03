<section class="cs-section" aria-labelledby="cs-title">
  <div class="cs-wrap">
    <header class="cs-hero">
      <h1 id="cs-title">Proyectos</h1>
      <p class="cs-lead">Casos reales de desarrollo web, integraciones y automatizaciones que reducen costes y mejoran la operación.</p>

      <!-- Filtros -->
      <div class="cs-filters" role="tablist" aria-label="Filtrar por tipo">
        <button class="cs-chip is-active" data-filter="all">Todos</button>
        <button class="cs-chip" data-filter="web">Web</button>
        <button class="cs-chip" data-filter="ecom">eCommerce</button>
        <button class="cs-chip" data-filter="integraciones">Integraciones</button>
        <button class="cs-chip" data-filter="auto">Automatizaciones</button>
      </div>
    </header>

    <!-- Grid -->
    <div class="cs-grid">
      <!-- Destacado ancho -->
      <article class="cs-card cs-card--wide" data-cat="integraciones auto">
        <figure class="cs-media">
          <img src="/assets/img/cases/erp-sync.jpg" alt="Sincronización ERP ↔ Tienda" loading="lazy">
          <span class="cs-cat">Integraciones</span>
        </figure>
        <div class="cs-body">
          <h3 class="cs-title">ERP ↔ Tienda online: catálogo, stock y pedidos en tiempo real</h3>
          <p class="cs-desc">API bidireccional, colas y webhooks. Menos errores humanos y disponibilidad de stock al minuto.</p>
          <ul class="cs-tags">
            <li>ERPNext</li><li>WooCommerce</li><li>n8n</li><li>Workers</li>
          </ul>
          <div class="cs-metrics">
            <div><strong>−72%</strong><span>tiempo de backoffice</span></div>
            <div><strong>99.9%</strong><span>uptime</span></div>
            <div><strong>+18%</strong><span>conversiones</span></div>
          </div>
          <a class="cs-cta" href="/proyectos/erp-sync">Ver proyecto</a>
        </div>
      </article>

      <!-- Tarjetas normales -->
      <article class="cs-card" data-cat="web">
        <figure class="cs-media">
          <img src="/assets/img/cases/corporativa.jpg" alt="Web corporativa" loading="lazy">
          <span class="cs-cat">Web</span>
        </figure>
        <div class="cs-body">
          <h3 class="cs-title">Web corporativa de alto rendimiento</h3>
          <p class="cs-desc">Next.js, accesibilidad AA y métricas Core Web Vitals en verde.</p>
          <ul class="cs-tags"><li>Next.js</li><li>SSR</li><li>A11y</li></ul>
          <a class="cs-cta" href="/proyectos/web-corporativa">Ver proyecto</a>
        </div>
      </article>

      <article class="cs-card" data-cat="ecom">
        <figure class="cs-media">
          <img src="/assets/img/cases/ecommerce.jpg" alt="Tienda online" loading="lazy">
          <span class="cs-cat">eCommerce</span>
        </figure>
        <div class="cs-body">
          <h3 class="cs-title">Tienda online con pasarelas y logística</h3>
          <p class="cs-desc">Pasarelas (Stripe/RedSys), cálculo de portes y feed de catálogo.</p>
          <ul class="cs-tags"><li>WooCommerce</li><li>Stripe</li><li>Feeds</li></ul>
          <a class="cs-cta" href="/proyectos/tienda-online">Ver proyecto</a>
        </div>
      </article>

      <article class="cs-card" data-cat="auto">
        <figure class="cs-media">
          <img src="/assets/img/cases/automatizacion.jpg" alt="Automatización de procesos" loading="lazy">
          <span class="cs-cat">Automatizaciones</span>
        </figure>
        <div class="cs-body">
          <h3 class="cs-title">Automatización de atención y reportes</h3>
          <p class="cs-desc">Bots de tickets, avisos en Slack y reportes semanales.</p>
          <ul class="cs-tags"><li>n8n</li><li>Slack</li><li>Webhook</li></ul>
          <a class="cs-cta" href="/proyectos/automatizacion">Ver proyecto</a>
        </div>
      </article>

      <article class="cs-card" data-cat="integraciones">
        <figure class="cs-media">
          <img src="/assets/img/cases/picking.jpg" alt="Picking & packing" loading="lazy">
          <span class="cs-cat">Integraciones</span>
        </figure>
        <div class="cs-body">
          <h3 class="cs-title">Picking &amp; packing: panel a medida</h3>
          <p class="cs-desc">Panel SPA para operativa de almacén con roles y auditoría.</p>
          <ul class="cs-tags"><li>SPA</li><li>RBAC</li><li>Logs</li></ul>
          <a class="cs-cta" href="/proyectos/picking-packing">Ver proyecto</a>
        </div>
      </article>

      <article class="cs-card" data-cat="web ecom">
        <figure class="cs-media">
          <img src="/assets/img/cases/headless.jpg" alt="Headless commerce" loading="lazy">
          <span class="cs-cat">Web</span>
        </figure>
        <div class="cs-body">
          <h3 class="cs-title">Headless commerce: contenido + checkout</h3>
          <p class="cs-desc">Front en Next.js + backend de comercio; rendimiento de app nativa.</p>
          <ul class="cs-tags"><li>Next.js</li><li>Headless</li><li>API</li></ul>
          <a class="cs-cta" href="/proyectos/headless">Ver proyecto</a>
        </div>
      </article>
    </div>
  </div>
</section>

<script>
  // Filtrado simple
  (function(){
    const chips = document.querySelectorAll('.cs-chip');
    const cards = document.querySelectorAll('.cs-card');
    chips.forEach(ch => ch.addEventListener('click', () => {
      chips.forEach(c=>c.classList.remove('is-active'));
      ch.classList.add('is-active');
      const f = ch.dataset.filter;
      cards.forEach(card=>{
        const ok = f === 'all' || card.dataset.cat.includes(f);
        card.style.display = ok ? '' : 'none';
      });
    }));
  })();
</script>

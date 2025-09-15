// public/assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {
  // Aquí irán inicializaciones por bloque si las necesitas.
  // Por ejemplo, observar elementos cuando entren en viewport, etc.
});
// public/assets/js/main.js
document.addEventListener('DOMContentLoaded', () => {
  // ===== Intersection Observer para .reveal y .stagger
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (!prefersReduced && 'IntersectionObserver' in window) {
    const io = new IntersectionObserver((entries) => {
      entries.forEach((e) => {
        if (e.isIntersecting) {
          e.target.classList.add('is-inview');
          io.unobserve(e.target);
        }
      });
    }, { rootMargin: '0px 0px -10% 0px', threshold: 0.08 });

    document.querySelectorAll('.reveal, .stagger').forEach(el => io.observe(el));
  } else {
    // Si prefiere menos animación: mostrar directo
    document.querySelectorAll('.reveal, .stagger').forEach(el => el.classList.add('is-inview'));
  }

  // ===== Glow sutil que sigue el ratón en botones primarios
  document.querySelectorAll('.btn-primary').forEach(btn => {
    btn.addEventListener('pointermove', (e) => {
      const r = btn.getBoundingClientRect();
      const x = ((e.clientX - r.left) / r.width) * 100;
      btn.style.setProperty('--mx', `${x}%`);
    });
  });

  // ===== Parallax ligero del H1 en la portada
  const heroTitle = document.querySelector('.portada h1');
  if (heroTitle && !prefersReduced) {
    const onScroll = () => {
      const y = window.scrollY || window.pageYOffset;
      heroTitle.style.transform = `translateY(${Math.min(y * 0.06, 18)}px)`;
    };
    window.addEventListener('scroll', onScroll, { passive: true });
  }
});
// ===== Animación "nodos de software" en el hero =====
(() => {
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const canvas = document.getElementById('hero-canvas');
  if (!canvas || prefersReduced) {
    // Muestra fallback si no animamos
    const fb = canvas?.nextElementSibling;
    if (fb) fb.style.display = 'grid';
    return;
  }

  const ctx = canvas.getContext('2d', { alpha: true });
  const DPR = Math.min(window.devicePixelRatio || 1, 2);

  // Colores (marca/acento)
  const BRAND = '#ff3b2f';
  const ACCENT = '#7cf7d1';

  let w = 0, h = 0, nodes = [], t = 0;

  function resize(){
    const rect = canvas.getBoundingClientRect();
    w = Math.floor(rect.width * DPR);
    h = Math.floor(rect.height * DPR);
    canvas.width = w; canvas.height = h;
    ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
    spawnNodes();
  }

  function rand(a,b){ return a + Math.random()*(b-a); }
  function spawnNodes(){
    const count = Math.floor((w/DPR) * (h/DPR) / 6000); // densidad adaptativa
    nodes = [];
    for (let i=0;i<count;i++){
      nodes.push({
        x: rand(20, (w/DPR)-20),
        y: rand(20, (h/DPR)-20),
        vx: rand(-0.25, 0.25),
        vy: rand(-0.25, 0.25),
        r: rand(1.5, 3.2),
        hue: Math.random() < 0.25 ? BRAND : ACCENT, // 25% marca, resto acento
        life: rand(0.5, 1)
      });
    }
  }

  function step(){
    t += 1/60;
    ctx.clearRect(0,0,w,h);

    // Fondo sutil
    const g = ctx.createLinearGradient(0,0,w,0);
    g.addColorStop(0,'rgba(124,247,209,0.05)');
    g.addColorStop(1,'rgba(255,59,47,0.05)');
    ctx.fillStyle = g;
    ctx.fillRect(0,0,w,h);

    // Actualiza y dibuja nodos
    for (const n of nodes){
      n.x += n.vx;
      n.y += n.vy;
      // rebote
      if (n.x < 12 || n.x > (w/DPR)-12) n.vx *= -1;
      if (n.y < 12 || n.y > (h/DPR)-12) n.vy *= -1;

      // brillo pulsante
      const pulse = 0.5 + 0.5 * Math.sin((t + n.life) * 2.0);

      // punto
      ctx.beginPath();
      ctx.arc(n.x, n.y, n.r + pulse*0.4, 0, Math.PI*2);
      ctx.fillStyle = n.hue === BRAND ? 'rgba(255,59,47,0.85)' : 'rgba(124,247,209,0.85)';
      ctx.shadowBlur = 14;
      ctx.shadowColor = n.hue;
      ctx.fill();

      // resetea sombra
      ctx.shadowBlur = 0;
    }

    // Conexiones cercanas
    for (let i=0;i<nodes.length;i++){
      for (let j=i+1;j<nodes.length;j++){
        const a = nodes[i], b = nodes[j];
        const dx = a.x - b.x, dy = a.y - b.y;
        const d2 = dx*dx + dy*dy;
        if (d2 < 160*160){ // umbral de enlace
          const d = Math.sqrt(d2);
          const alpha = Math.max(0, 1 - d/160) * 0.45;
          ctx.beginPath();
          ctx.moveTo(a.x, a.y);
          ctx.lineTo(b.x, b.y);
          // degradado según mezcla de colores
          const lg = ctx.createLinearGradient(a.x, a.y, b.x, b.y);
          lg.addColorStop(0, a.hue === BRAND ? 'rgba(255,59,47,'+alpha+')' : 'rgba(124,247,209,'+alpha+')');
          lg.addColorStop(1, b.hue === BRAND ? 'rgba(255,59,47,'+alpha+')' : 'rgba(124,247,209,'+alpha+')');
          ctx.strokeStyle = lg;
          ctx.lineWidth = 1;
          ctx.stroke();
        }
      }
    }

    requestAnimationFrame(step);
  }

  // Inicia
  resize();
  window.addEventListener('resize', resize);
  requestAnimationFrame(step);
})();

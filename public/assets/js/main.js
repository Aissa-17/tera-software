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
// ===== Globo terráqueo ligero (contacto) con tooltips =====
(() => {
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const canvas = document.getElementById('globe-canvas');
  if (!canvas || prefersReduced) {
    const fb = canvas?.nextElementSibling; if (fb) fb.style.display = 'grid';
    return;
  }

  const wrap = canvas.parentElement; // .contact-visual
  // Tooltip DOM
  const tip = document.createElement('div');
  tip.className = 'globe-tooltip';
  tip.style.display = 'none';
  wrap.appendChild(tip);

  const ctx = canvas.getContext('2d', { alpha: true });
  const DPR = Math.min(window.devicePixelRatio || 1, 2);
  let w=0, h=0, r=0, cx=0, cy=0, t=0;
  let running = false;

  function resize(){
    const rect = canvas.getBoundingClientRect();
    w = Math.floor(rect.width * DPR);
    h = Math.floor(rect.height * DPR);
    canvas.width = w; canvas.height = h;
    ctx.setTransform(DPR, 0, 0, DPR, 0, 0);
    cx = (w/DPR) * 0.5;
    cy = (h/DPR) * 0.52;
    r  = Math.min(w/DPR, h/DPR) * 0.35;
  }

  // Puntos con etiqueta
  const points = [
    {lat: 40.4,  lon: -3.7,   label: 'Madrid (EU)'},
    {lat: 48.86, lon:  2.35,  label: 'París'},
    {lat: 51.5,  lon: -0.12,  label: 'Londres'},
    {lat: 37.77, lon: -122.4, label: 'San Francisco (US)'},
    {lat: -34.6, lon: -58.4,  label: 'Buenos Aires (LatAm)'},
  ];

  function proj(lat, lon, rot){ // devuelve coords en píxeles CSS
    const φ = lat * Math.PI/180;
    const λ = lon * Math.PI/180 + rot;
    const x = Math.cos(φ) * Math.cos(λ);
    const y = Math.sin(φ);
    const z = Math.cos(φ) * Math.sin(λ);
    if (z < -0.1) return null; // oculta cara trasera
    const k = r;
    return { x: cx + x * k, y: cy - y * k, z };
  }

  function lineMeridian(rot, λ0, color, alpha){
    ctx.beginPath();
    for (let φ=-80; φ<=80; φ+=4){
      const p = proj(φ, λ0, rot);
      if (!p) continue;
      if (φ === -80) ctx.moveTo(p.x, p.y); else ctx.lineTo(p.x, p.y);
    }
    ctx.strokeStyle = color; ctx.globalAlpha = alpha; ctx.stroke(); ctx.globalAlpha = 1;
  }
  function lineParallel(rot, φ0, color, alpha){
    ctx.beginPath();
    for (let λ=-180; λ<=180; λ+=4){
      const p = proj(φ0, λ, rot);
      if (!p) continue;
      if (λ === -180) ctx.moveTo(p.x, p.y); else ctx.lineTo(p.x, p.y);
    }
    ctx.strokeStyle = color; ctx.globalAlpha = alpha; ctx.stroke(); ctx.globalAlpha = 1;
  }

  // cache de posiciones para hit-test del tooltip
  let screenPts = [];

  function step(){
    if (!running) return;
    t += 0.016;
    const rot = t * 0.35;

    ctx.clearRect(0,0,w,h);

    // halo y esfera
    const g = ctx.createRadialGradient(cx, cy, r*0.7, cx, cy, r*1.25);
    g.addColorStop(0, 'rgba(124,247,209,0.08)');
    g.addColorStop(1, 'rgba(255,59,47,0.06)');
    ctx.fillStyle = g; ctx.beginPath(); ctx.arc(cx, cy, r*1.25, 0, Math.PI*2); ctx.fill();

    ctx.beginPath(); ctx.arc(cx, cy, r, 0, Math.PI*2);
    const g2 = ctx.createRadialGradient(cx - r*0.3, cy - r*0.3, r*0.2, cx, cy, r);
    g2.addColorStop(0, '#0f141d'); g2.addColorStop(1, '#0a0f16');
    ctx.fillStyle = g2; ctx.fill();
    ctx.lineWidth = 1; ctx.strokeStyle = 'rgba(124,247,209,0.12)'; ctx.stroke();

    // wireframe
    ctx.lineWidth = 1;
    for (let λ=-180; λ<=180; λ+=20) lineMeridian(rot, λ, 'rgba(124,247,209,0.25)', 0.35);
    for (let φ=-60; φ<=60; φ+=20)   lineParallel(rot, φ, 'rgba(124,247,209,0.25)', 0.35);

    // puntos y posiciones en pantalla
    screenPts = [];
    for (const pt of points){
      const p = proj(pt.lat, pt.lon, rot);
      if (!p) continue;
      const pulse = 0.5 + 0.5 * Math.sin((t*2) + (pt.lat+pt.lon));
      const rr = 2 + pulse*1.2;

      // glow
      ctx.beginPath(); ctx.arc(p.x, p.y, rr+3, 0, Math.PI*2);
      ctx.fillStyle = 'rgba(255,59,47,0.25)'; ctx.fill();
      // núcleo
      ctx.beginPath(); ctx.arc(p.x, p.y, rr, 0, Math.PI*2);
      ctx.fillStyle = 'rgba(124,247,209,0.95)'; ctx.fill();

      screenPts.push({ x:p.x, y:p.y, r: rr+6, label: pt.label });
    }

    requestAnimationFrame(step);
  }

  // ------- Tooltips (hit test en CSS px) -------
  function showTip(x, y, text){
    tip.textContent = text;
    tip.style.display = 'block';
    tip.style.left = `${x}px`;
    tip.style.top  = `${y}px`;
    tip.classList.add('is-visible');
  }
  function hideTip(){
    tip.classList.remove('is-visible');
    tip.style.display = 'none';
  }

  wrap.addEventListener('pointermove', (e)=>{
    const rect = wrap.getBoundingClientRect();
    const mx = e.clientX - rect.left;
    const my = e.clientY - rect.top;

    let found = null, minD = 1e9;
    for (const p of screenPts){
      const dx = mx - p.x, dy = my - p.y;
      const d2 = dx*dx + dy*dy;
      if (d2 < (p.r*p.r) && d2 < minD){ minD = d2; found = p; }
    }
    if (found) showTip(found.x, found.y, found.label);
    else hideTip();
  });
  wrap.addEventListener('pointerleave', hideTip);

  // ------- Lifecycle -------
  resize();
  window.addEventListener('resize', resize);

  if ('IntersectionObserver' in window){
    const io = new IntersectionObserver(([e])=>{
      if (e.isIntersecting){ running = true; requestAnimationFrame(step); }
      else { running = false; hideTip(); }
    }, {threshold:0.1});
    io.observe(wrap);
  } else {
    running = true; requestAnimationFrame(step);
  }
})();
document.addEventListener('DOMContentLoaded', () => {
  // Toggle dropdown idioma
  const dd = document.querySelector('.lang-dropdown');
  if (dd) {
    const btn = dd.querySelector('.lang-btn');
    btn.addEventListener('click', (e) => {
      e.stopPropagation();
      dd.classList.toggle('open');
      btn.setAttribute('aria-expanded', dd.classList.contains('open') ? 'true' : 'false');
    });
    document.addEventListener('click', () => dd.classList.remove('open'));
    dd.querySelectorAll('.lang-menu a').forEach(a => {
      a.addEventListener('click', () => dd.classList.remove('open')); // navegación se hace por href ?lang=xx
    });
  }
});
// === Dropdown contraste ===
const cdd = document.querySelector('.contrast-dropdown');
if (cdd) {
  const btn = cdd.querySelector('.contrast-btn');
  const menu = cdd.querySelector('.contrast-menu');
  const setContrast = (level) => {
    document.body.classList.remove('contrast-high','contrast-max');
    if (level === 'high') document.body.classList.add('contrast-high');
    if (level === 'max')  document.body.classList.add('contrast-max');
    // marcar selección visual
    menu.querySelectorAll('[data-contrast]').forEach(a=>{
      a.setAttribute('aria-selected', a.dataset.contrast === level ? 'true' : 'false');
    });
    // persistir
    localStorage.setItem('contrast', level);
    // actualizar etiqueta del botón
    const label = cdd.querySelector('.contrast-label');
    if (label) {
      label.textContent = (level === 'high') ? (window.__t?.('contrast.high') || 'High contrast')
                        : (level === 'max')  ? (window.__t?.('contrast.max')  || 'Max contrast')
                        : (window.__t?.('contrast.normal') || 'Standard');
    }
  };

  // preferencia del usuario/sistema
  let initial = localStorage.getItem('contrast');
  if (!initial && window.matchMedia) {
    // si el sistema pide más contraste, arrancamos en "high"
    const mq = window.matchMedia('(prefers-contrast: more)');
    if (mq.matches) initial = 'high';
  }
  setContrast(initial || 'normal');

  btn.addEventListener('click', (e)=>{
    e.stopPropagation();
    cdd.classList.toggle('open');
    btn.setAttribute('aria-expanded', cdd.classList.contains('open') ? 'true' : 'false');
  });
  document.addEventListener('click', ()=> cdd.classList.remove('open'));

  menu.querySelectorAll('a[data-contrast]').forEach(a=>{
    a.addEventListener('click', (e)=>{
      e.preventDefault();
      setContrast(a.dataset.contrast);
      cdd.classList.remove('open');
    });
  });
}

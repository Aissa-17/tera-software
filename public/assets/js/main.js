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

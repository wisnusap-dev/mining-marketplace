/* ==========================================================
   user.js — Semua efek visual halaman user
   - Page loader
   - Scroll-reveal (Intersection Observer)
   - Lazy loading gambar
   - Particle canvas (hero)
   - Counter animasi (stats)
   - Parallax hero
   - Magnetic cursor
   - Typed text
   - Product card tilt
   - Smooth scroll progress bar
   - Navbar hide-on-scroll
   - Toast notification
   ========================================================== */

/* ─── 1. PAGE LOADER ─────────────────────────────────────── */
(function () {
  const loader = document.getElementById('user-loader');
  if (!loader) return;
  window.addEventListener('load', () => {
    setTimeout(() => {
      loader.classList.add('out');
      setTimeout(() => loader.remove(), 600);
    }, 500);
  });
})();

/* ─── 2. SCROLL PROGRESS BAR ─────────────────────────────── */
(function () {
  const bar = document.getElementById('scroll-progress');
  if (!bar) return;
  window.addEventListener('scroll', () => {
    const total  = document.documentElement.scrollHeight - window.innerHeight;
    const pct    = total > 0 ? (window.scrollY / total) * 100 : 0;
    bar.style.width = pct + '%';
  }, { passive: true });
})();

/* ─── 3. NAVBAR — hide on scroll down, show on scroll up ─── */
(function () {
  const nav = document.querySelector('.navbar');
  if (!nav) return;
  let last = 0;
  window.addEventListener('scroll', () => {
    const curr = window.scrollY;
    if (curr > 100) {
      nav.classList.toggle('navbar-hidden', curr > last);
    } else {
      nav.classList.remove('navbar-hidden');
    }
    last = curr;
  }, { passive: true });
})();

/* ─── 4. SCROLL REVEAL (Intersection Observer) ───────────── */
(function () {
  const els = document.querySelectorAll('.reveal');
  if (!els.length) return;

  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('revealed');
        io.unobserve(e.target);
      }
    });
  }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });

  els.forEach(el => io.observe(el));
})();

/* ─── 5. LAZY LOADING IMAGES ─────────────────────────────── */
(function () {
  const imgs = document.querySelectorAll('img[data-src]');
  if (!imgs.length) return;

  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const img = e.target;
      img.src = img.dataset.src;
      img.addEventListener('load', () => img.classList.add('img-loaded'));
      io.unobserve(img);
    });
  }, { rootMargin: '100px' });

  imgs.forEach(img => io.observe(img));
})();

/* ─── 6. COUNTER ANIMATION (stat numbers) ────────────────── */
(function () {
  const els = document.querySelectorAll('.count-up');
  if (!els.length) return;

  const io = new IntersectionObserver((entries) => {
    entries.forEach(e => {
      if (!e.isIntersecting) return;
      const el     = e.target;
      const target = parseFloat(el.dataset.target);
      const suffix = el.dataset.suffix || '';
      const dur    = 1600;
      const step   = 16;
      const steps  = dur / step;
      let curr     = 0;
      const inc    = target / steps;
      const timer  = setInterval(() => {
        curr += inc;
        if (curr >= target) {
          curr = target;
          clearInterval(timer);
        }
        el.textContent = (Number.isInteger(target)
          ? Math.floor(curr).toLocaleString('id-ID')
          : curr.toFixed(1)) + suffix;
      }, step);
      io.unobserve(el);
    });
  }, { threshold: 0.5 });

  els.forEach(el => io.observe(el));
})();

/* ─── 7. PARTICLE CANVAS (hero background) ───────────────── */
(function () {
  const canvas = document.getElementById('hero-canvas');
  if (!canvas) return;
  const ctx = canvas.getContext('2d');
  let W, H, particles;

  function resize() {
    W = canvas.width  = canvas.offsetWidth;
    H = canvas.height = canvas.offsetHeight;
  }

  function makeParticle() {
    return {
      x:   Math.random() * W,
      y:   Math.random() * H,
      r:   Math.random() * 1.4 + 0.3,
      vx:  (Math.random() - 0.5) * 0.3,
      vy:  -Math.random() * 0.4 - 0.1,
      o:   Math.random() * 0.5 + 0.15,
    };
  }

  function init() {
    resize();
    particles = Array.from({ length: 80 }, makeParticle);
  }

  function draw() {
    ctx.clearRect(0, 0, W, H);
    particles.forEach(p => {
      ctx.beginPath();
      ctx.arc(p.x, p.y, p.r, 0, Math.PI * 2);
      ctx.fillStyle = `rgba(201,151,58,${p.o})`;
      ctx.fill();
      p.x += p.vx;
      p.y += p.vy;
      if (p.y < -5) { p.y = H + 5; p.x = Math.random() * W; }
      if (p.x < -5 || p.x > W + 5) p.vx *= -1;
    });
    requestAnimationFrame(draw);
  }

  window.addEventListener('resize', () => { resize(); });
  init();
  draw();
})();

/* ─── 8. HERO PARALLAX ───────────────────────────────────── */
(function () {
  const content = document.querySelector('.hero-content');
  const glow    = document.querySelector('.hero-glow');
  if (!content) return;

  window.addEventListener('scroll', () => {
    const y = window.scrollY;
    content.style.transform = `translateY(${y * 0.18}px)`;
    if (glow) glow.style.transform = `translateY(calc(-50% + ${y * 0.08}px))`;
  }, { passive: true });
})();

/* ─── 9. TYPED TEXT (hero sub heading) ───────────────────── */
(function () {
  const el = document.getElementById('typed-text');
  if (!el) return;
  const words = el.dataset.words ? el.dataset.words.split('|') : [];
  if (!words.length) return;
  let wi = 0, ci = 0, del = false;

  function type() {
    const word = words[wi];
    if (!del) {
      el.textContent = word.slice(0, ++ci);
      if (ci === word.length) { del = true; setTimeout(type, 2000); return; }
    } else {
      el.textContent = word.slice(0, --ci);
      if (ci === 0) { del = false; wi = (wi + 1) % words.length; }
    }
    setTimeout(type, del ? 60 : 90);
  }
  type();
})();

/* ─── 10. PRODUCT CARD 3D TILT ───────────────────────────── */
(function () {
  document.querySelectorAll('.product-card').forEach(card => {
    card.addEventListener('mousemove', e => {
      const r    = card.getBoundingClientRect();
      const x    = e.clientX - r.left;
      const y    = e.clientY - r.top;
      const cx   = r.width  / 2;
      const cy   = r.height / 2;
      const rotX = ((y - cy) / cy) * -5;
      const rotY = ((x - cx) / cx) *  5;
      card.style.transform = `perspective(700px) rotateX(${rotX}deg) rotateY(${rotY}deg) translateY(-6px)`;
    });
    card.addEventListener('mouseleave', () => {
      card.style.transform = '';
    });
  });
})();

/* ─── 11. SKELETON → REAL (product grid) ────────────────── */
(function () {
  const skeletons = document.querySelectorAll('.skeleton-card');
  const grid      = document.getElementById('productGrid');
  if (!skeletons.length || !grid) return;

  // Skeleton sudah dirender server-side, animasi sudah via CSS.
  // Kita hanya perlu trigger reveal setelah gambar-gambar load.
  window.addEventListener('load', () => {
    skeletons.forEach((s, i) => {
      setTimeout(() => s.classList.add('sk-out'), i * 60);
    });
    grid.querySelectorAll('.product-card').forEach((c, i) => {
      c.style.opacity = '0';
      c.style.transform = 'translateY(24px)';
      setTimeout(() => {
        c.style.transition = 'opacity 0.45s ease, transform 0.45s ease';
        c.style.opacity = '1';
        c.style.transform = '';
      }, i * 80 + 200);
    });
  });
})();

/* ─── 12. TOAST NOTIFICATION ────────────────────────────── */
window.showToast = function (msg, type = 'success') {
  const t = document.createElement('div');
  t.className = `user-toast user-toast-${type}`;
  t.innerHTML = `<span>${msg}</span>`;
  document.body.appendChild(t);
  requestAnimationFrame(() => t.classList.add('show'));
  setTimeout(() => {
    t.classList.remove('show');
    setTimeout(() => t.remove(), 400);
  }, 3000);
};

/* ─── 13. CART BUTTON FEEDBACK ───────────────────────────── */
document.addEventListener('DOMContentLoaded', () => {
  document.querySelectorAll('.btn-cart').forEach(btn => {
    btn.addEventListener('click', function (e) {
      const original = this.innerHTML;
      this.innerHTML = '✓ Ditambahkan';
      this.style.background = 'var(--gold)';
      this.style.color = 'var(--brown)';
      setTimeout(() => {
        this.innerHTML = original;
        this.style.background = '';
        this.style.color = '';
      }, 1200);
    });
  });

  /* ─── 14. SMOOTH PAGE TRANSITIONS ───────────────────────── */
  document.querySelectorAll('a[href]').forEach(a => {
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('http') || href.startsWith('..')) return;
    if (a.target === '_blank') return;
    a.addEventListener('click', function (e) {
      const loader = document.getElementById('user-loader');
      if (!loader) return;
      e.preventDefault();
      loader.classList.remove('out');
      setTimeout(() => { window.location.href = href; }, 350);
    });
  });
});

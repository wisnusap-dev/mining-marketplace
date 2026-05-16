/* ============================================================
   admin.js — Shared admin JS: loader, sidebar, skeleton, etc.
   ============================================================ */

// ===== PAGE LOADER =====
window.addEventListener('load', function () {
  const loader = document.getElementById('page-loader');
  if (loader) {
    setTimeout(() => loader.classList.add('hidden'), 700);
  }
});

// ===== SIDEBAR TOGGLE (mobile) =====
function toggleSidebar() {
  const sidebar = document.getElementById('sidebar');
  const overlay = document.getElementById('sidebar-overlay');
  if (sidebar) sidebar.classList.toggle('open');
  if (overlay) overlay.classList.toggle('open');
}

document.addEventListener('DOMContentLoaded', function () {
  const overlay = document.getElementById('sidebar-overlay');
  if (overlay) {
    overlay.addEventListener('click', toggleSidebar);
  }

  // ===== SKELETON → REAL CONTENT =====
  // Setelah DOM siap, hilangkan skeleton dan tampilkan konten asli
  const skeletons = document.querySelectorAll('.skeleton-screen');
  const reals     = document.querySelectorAll('.real-content');

  if (skeletons.length > 0) {
    setTimeout(() => {
      skeletons.forEach(el => el.style.display = 'none');
      reals.forEach(el => {
        el.style.display = '';
        el.classList.add('fade-up');
      });
    }, 600);
  }

  // ===== FILE UPLOAD PREVIEW =====
  const fileInput = document.getElementById('imgInput');
  const uploadName = document.getElementById('uploadName');
  if (fileInput && uploadName) {
    fileInput.addEventListener('change', function () {
      uploadName.textContent = this.files[0] ? this.files[0].name : '';
    });
  }

  // ===== CONFIRM DIALOGS =====
  document.querySelectorAll('[data-confirm]').forEach(el => {
    el.addEventListener('click', function (e) {
      if (!confirm(this.getAttribute('data-confirm'))) {
        e.preventDefault();
      }
    });
  });

  // ===== COUNT-UP ANIMATION for stat values =====
  document.querySelectorAll('.stat-value[data-target]').forEach(el => {
    const target = parseInt(el.getAttribute('data-target'), 10);
    let current  = 0;
    const step   = Math.ceil(target / 40);
    const timer  = setInterval(() => {
      current += step;
      if (current >= target) {
        current = target;
        clearInterval(timer);
      }
      el.textContent = current.toLocaleString('id-ID');
    }, 30);
  });
});

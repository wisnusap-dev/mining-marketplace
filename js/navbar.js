// 1. Toggle Hamburger Menu
const menu = document.querySelector('#mobile-menu');
const navMenu = document.querySelector('.nav-menu');

menu.addEventListener('click', () => {
    navMenu.classList.toggle('active');
    menu.classList.toggle('is-active'); // Opsional: untuk animasi hamburger
});

// 2. Logic Active Link (Garis Bawah)
const navLinks = document.querySelectorAll('.nav-link');

navLinks.forEach(link => {
    link.addEventListener('click', function() {
        // Hapus class 'active' dari semua link
        navLinks.forEach(nav => nav.classList.remove('active'));
        // Tambahkan class 'active' ke link yang diklik
        this.classList.add('active');
        
        // Tutup menu mobile setelah klik (opsional)
        navMenu.classList.remove('active');
    });
});
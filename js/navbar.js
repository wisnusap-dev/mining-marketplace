document.addEventListener('DOMContentLoaded', () => {
    const menuToggle = document.querySelector('.menu-toggle');
    const navMenu = document.querySelector('#gen-menu');

    // Pastikan elemen ada sebelum menambah event listener
    if (menuToggle && navMenu) {
        menuToggle.addEventListener('click', () => {
            // Menambah/menghapus class 'active' pada ul
            navMenu.classList.toggle('active');
            
            // Opsional: Animasi hamburger (jika kamu menambah CSS untuk ini)
            menuToggle.classList.toggle('is-active');
        });
    }
});
window.addEventListener("load",function(){
    document.getElementById("loader").style.display="none";
});
const menu = document.querySelector('#mobile-menu');
const menuLinks = document.querySelector('#gen-menu');

menu.addEventListener('click', function() {
    menu.classList.toggle('is-active');
    menuLinks.classList.toggle('active');
});
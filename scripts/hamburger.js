const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('nav-links');
const navItems = navLinks.querySelectorAll('li a');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        navLinks.classList.remove('active');
    }
});

navItems.forEach(item => {
    item.addEventListener('click', () => {
        navLinks.classList.remove('active'); 
    });
});
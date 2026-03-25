document.addEventListener("DOMContentLoaded", function() {

    /* Navbar Scroll Effect */
    const navbar = document.querySelector('.navbar');
    window.addEventListener('scroll', () => {
        if(window.scrollY > 50){
            navbar.classList.add('navbar-scrolled');
        } else {
            navbar.classList.remove('navbar-scrolled');
        }
    });

    /* Smooth Scroll for Navbar Links */
    const links = document.querySelectorAll('.navbar-nav .nav-link');
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            if(link.getAttribute('href').startsWith('#')){
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('href'));
                if(target){
                    window.scrollTo({
                        top: target.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });

    /* Scroll Reveal / Fade In */
    const faders = document.querySelectorAll('.fade-in');
    const appearOptions = {
        threshold: 0.3,
        rootMargin: "0px 0px -100px 0px"
    };
    const appearOnScroll = new IntersectionObserver(function(entries, observer){
        entries.forEach(entry => {
            if(!entry.isIntersecting) return;
            entry.target.classList.add('appear');
            observer.unobserve(entry.target);
        });
    }, appearOptions);

    faders.forEach(fader => {
        appearOnScroll.observe(fader);
    });

    /* Hero Button Hover Effect */
    const heroBtn = document.querySelector('.hero .btn-primary');
    if(heroBtn){
        heroBtn.addEventListener('mouseenter', () => {
            heroBtn.style.transform = "scale(1.1)";
            heroBtn.style.boxShadow = "0 12px 25px rgba(0,0,0,0.3)";
        });
        heroBtn.addEventListener('mouseleave', () => {
            heroBtn.style.transform = "scale(1)";
            heroBtn.style.boxShadow = "0 8px 20px rgba(0,0,0,0.3)";
        });
    }

});
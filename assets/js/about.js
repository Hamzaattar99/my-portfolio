document.addEventListener("DOMContentLoaded", function() {

    const elements = document.querySelectorAll('.fade-in');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if(!entry.isIntersecting) return;

            entry.target.classList.add('appear');
            observer.unobserve(entry.target);
        });
    }, {
        threshold: 0.3
    });

    elements.forEach(el => {
        observer.observe(el);
    });

});
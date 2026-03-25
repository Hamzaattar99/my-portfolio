document.addEventListener("DOMContentLoaded", function() {

    /* Fade-in */
    const elements = document.querySelectorAll('.fade-in');

    const observer = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if(!entry.isIntersecting) return;

            entry.target.classList.add('appear');

            // Animate Progress Bars
            const bar = entry.target.querySelector('.progress-bar');
            if(bar){
                let level = bar.getAttribute('data-level');

                if(level === "Beginner") bar.style.width = "40%";
                if(level === "Intermediate") bar.style.width = "70%";
                if(level === "Advanced") bar.style.width = "95%";
            }

            observer.unobserve(entry.target);
        });
    }, { threshold: 0.3 });

    elements.forEach(el => observer.observe(el));

});
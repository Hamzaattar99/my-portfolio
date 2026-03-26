// تأثير بسيط خفيف (بدون ضغط على الأداء)
document.querySelectorAll('.admin-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const x = e.offsetX;
        const y = e.offsetY;
        card.style.transform = `rotateX(${y/20}deg) rotateY(${x/20}deg)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = "rotateX(0) rotateY(0)";
    });
});
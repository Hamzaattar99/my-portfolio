// تأثير بسيط خفيف (بدون ضغط على الأداء)
document.querySelectorAll('.admin-card').forEach(card => {
    card.addEventListener('mousemove', (e) => {
        const x = e.offsetX;
        const y = e.offsetY;
        card.style.transform = `rotateX(${y/50}deg) rotateY(${x/50}deg)`;
    });

    card.addEventListener('mouseleave', () => {
        card.style.transform = "rotateX(0) rotateY(0)";
    });
});

function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
}
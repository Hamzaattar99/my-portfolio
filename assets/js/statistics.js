function updateClock(){
    const now = new Date();
    document.getElementById("clock").innerText = now.toLocaleString();
}

setInterval(updateClock, 1000);
updateClock();

function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
}
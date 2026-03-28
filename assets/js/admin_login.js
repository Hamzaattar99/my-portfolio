let attempts = 0;
let locked = false;

function login(){
    if(locked) return;

    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    document.getElementById("userError").innerText = "";
    document.getElementById("passError").innerText = "";

    if(!username){
        document.getElementById("userError").innerText = "Username required";
        return;
    }
    
    if(!password){
        document.getElementById("passError").innerText = "Password required";
        return;
    }

    fetch("login_action.php", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
    })
    .then(res => res.json())
    .then(data => {

        if(data.success){
            document.getElementById("messageBox").innerHTML =
                "<div class='text-success'>Login successful...</div>";

            setTimeout(()=>{
                window.location.href = "adminDashboard.php";
            },1000);

        } else {
            attempts++;

            let message = "Invalid credentials";

            if(data.reason == "inactive")
            {
                message = "Your account is not active";
            }
            
            document.getElementById("messageBox").innerHTML =
                `<div class='text-danger'>${message}</div>`;

            if(attempts >= 3){
                lockSystem();
            }
        }
    });
}

function lockSystem(){
    locked = true;
    let time = 60;

    let box = document.getElementById("messageBox");
    box.innerHTML = `<div class="lock-timer" id="timer">${time}</div>
                     <div class="text-warning">Too many attempts</div>`;

    let interval = setInterval(()=>{
        time--;
        document.getElementById("timer").innerText = time;

        if(time <= 0){
            clearInterval(interval);
            locked = false;
            attempts = 0;
            box.innerHTML = "";
        }
    },1000);
}
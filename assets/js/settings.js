function changePassword(){
    fetch("settings_actions.php",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=change_password&old=${old_password.value}&new=${new_password.value}`
    })
    .then(res=>res.text())
    .then(data=>passMsg.innerText=data);
}

function addAdmin(){
    fetch("settings_actions.php",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=add_admin&user=${new_user.value}&pass=${new_pass.value}`
    })
    .then(res=>res.text())
    .then(data=>adminMsg.innerText=data);
}

function saveLinks(){
    fetch("settings_actions.php",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`action=save_links&facebook=${facebook.value}&github=${github.value}&twitter=${twitter.value}&instagram=${instagram.value}&linkedin=${linkedin.value}&email=${email.value}`
    })
    .then(res=>res.text())
    .then(data=>linksMsg.innerText=data);
}

function backup(){
    window.location.href = "settings_actions.php?action=backup";
}

function confirmLogout(){
    if(confirm("Logout?")){
        window.location.href = "logout.php";
    }
}
function openFor(){

  

    let modal = new bootstrap.Modal(document.getElementById("adminModal"));
    modal.show();

    document.getElementById("formTitle").innerText = "Add Admin";

    // مهم جداً
    document.getElementById("admin_id").value = "";

    document.getElementById("username").value = "";
    document.getElementById("password").value = "";

    // إعادة القيم الافتراضية
    document.getElementById("role").value = "admin";
    document.getElementById("status").value = "1"; 
}

function editAdmin(id, username, role, status){
    let modal = new bootstrap.Modal(document.getElementById("adminModal"));
    modal.show();

    document.getElementById("formTitle").innerText="Edit Admin";
    document.getElementById("admin_id").value=id;
    document.getElementById("username").value=username;
    document.getElementById("password").value=""; // لا يظهر
    document.getElementById("role").value=role;
    document.getElementById("status").value=status;
}

function saveAdmin(){
    let data = new FormData();
    data.append("id", document.getElementById("admin_id").value);
    data.append("username", document.getElementById("username").value);
    data.append("password", document.getElementById("password").value);
    data.append("role", document.getElementById("role").value);
    data.append("status", document.getElementById("status").value);

    fetch("admin_actions.php",{
        method:"POST",
        body:data
    }).then(()=>location.reload());
}

function deleteAdmin(id){
    if(confirm("Delete this admin?")){
        fetch("delete.php",{
            method:"POST",
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`id=${id}&type=user`
        }).then(()=>location.reload());
    }
}

function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
}
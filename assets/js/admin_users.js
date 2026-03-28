function openForm(){
    document.getElementById("formTitle").innerText="Add Admin";
    document.getElementById("admin_id").value="";
    document.getElementById("username").value="";
    document.getElementById("password").value="";
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
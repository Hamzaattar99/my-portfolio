function openForm(add=true){
    new bootstrap.Modal(document.getElementById('expModal')).show();

    if(add){
        formTitle.innerText="Add Experience";
        exp_id.value="";
        title_en.value="";
        title_ar.value="";
        company.value="";
        desc_en.value="";
        desc_ar.value="";
        start_date.value="";
        end_date.value="";
    }
}

function editExp(id,en,ar,comp,den,dar,start,end){
    openForm(false);
    formTitle.innerText="Edit Experience";

    exp_id.value=id;
    title_en.value=en;
    title_ar.value=ar;
    company.value=comp;
    desc_en.value=den;
    desc_ar.value=dar;
    start_date.value=start;
    end_date.value=end;
}

function saveExp(){
    let data = new URLSearchParams();
    data.append("id", exp_id.value);
    data.append("title_en", title_en.value);
    data.append("title_ar", title_ar.value);
    data.append("company", company.value);
    data.append("desc_en", desc_en.value);
    data.append("desc_ar", desc_ar.value);
    data.append("start_date", start_date.value);
    data.append("end_date", end_date.value);

    fetch("experience_actions.php",{
        method:"POST",
        body:data
    }).then(()=>location.reload());
}

function deleteExp(id){
    if(confirm("Delete this experience?")){
        fetch("delete.php",{
            method:"POST",
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`id=${id}&type=experience`
        }).then(()=>location.reload());
    }
}

searchInput.addEventListener("input",function(){
    fetch(`experience_actions.php?action=search&q=${this.value}`)
    .then(res=>res.text())
    .then(html=>{
        experienceContainer.innerHTML=html;
    });
});

function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
}
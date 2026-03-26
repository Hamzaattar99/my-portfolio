let currentLang = 'en'; // default description language
let currentProjectID = null;

function openForm(isAdd = true){
    const formTitle = document.getElementById("formTitle");
    const projectId = document.getElementById("project_id");
    const titleEn = document.getElementById("title_en");
    const titleAr = document.getElementById("title_ar");
    const descEn = document.getElementById("description_en");
    const descAr = document.getElementById("description_ar");
    const tech = document.getElementById("technologies");
    const github = document.getElementById("github_link");
    const live = document.getElementById("live_link");
    const img = document.getElementById("project_image");

    if(isAdd){
        formTitle.innerText = "Add Project";
        projectId.value = "";
        titleEn.value = "";
        titleAr.value = "";
        descEn.value = "";
        descAr.value = "";
        tech.value = "";
        github.value = "";
        live.value = "";
        img.value = "";
    }
}

function editProject(id, enTitle, arTitle, enDesc, arDesc, techs, github, live, image){
    openForm(false);
    document.getElementById("formTitle").innerText="Edit Project";
    document.getElementById("project_id").value=id;
    document.getElementById("title_en").value=enTitle;
    document.getElementById("title_ar").value=arTitle;
    document.getElementById("description_en").value=enDesc;
    document.getElementById("description_ar").value=arDesc;
    document.getElementById("technologies").value=techs;
    document.getElementById("github_link").value=github;
    document.getElementById("live_link").value=live;
}

function viewProject(id){

    currentProjectID = id;

    fetch(`projects_actions.php?action=get&id=${id}`)
    .then(res => res.json())
    .then(data => {
        document.getElementById("detailsTitle").innerText = data.project_title_en;
        document.getElementById("detailsTitleEn").innerText = data.project_title_en;
        document.getElementById("detailsTitleAr").innerText = data.project_title_ar;
        document.getElementById("detailsDescription").innerText = data.project_description_en;
        document.getElementById("detailsTechnologies").innerText = data.project_technologies;
        document.getElementById("detailsGithub").href = data.github_link;
        document.getElementById("detailsLive").href = data.live_link || "#";
        document.getElementById("detailsImage").src = data.project_image ? `../assets/images/${data.project_image}` : 'https://via.placeholder.com/150';
        currentLang = 'en';
    });
}

function toggleDescriptionLang(){

    if(!currentLang) return;

    const descEl = document.getElementById("detailsDescription");
    const en = document.getElementById("detailsTitleEn").innerText;
    const ar = document.getElementById("detailsTitleAr").innerText;
    fetch(`projects_actions.php?action=get&id=${currentProjectID}`)
        .then(res => res.json())
        .then(data => {
            if(currentLang==='en'){
                descEl.innerText = data.project_description_ar;
                currentLang='ar';
            } else {
                descEl.innerText = data.project_description_en;
                currentLang='en';
            }
        });
}

function saveProject(){
    let formData = new FormData();
    formData.append("id", document.getElementById("project_id").value);
    formData.append("title_en", document.getElementById("title_en").value);
    formData.append("title_ar", document.getElementById("title_ar").value);
    formData.append("description_en", document.getElementById("description_en").value);
    formData.append("description_ar", document.getElementById("description_ar").value);
    formData.append("technologies", document.getElementById("technologies").value);
    formData.append("github_link", document.getElementById("github_link").value);
    formData.append("live_link", document.getElementById("live_link").value);
    if(document.getElementById("project_image").files[0]){
        formData.append("project_image", document.getElementById("project_image").files[0]);
    }

    fetch("projects_actions.php",{
        method:"POST",
        body: formData
    }).then(()=>location.reload());
}

function deleteProject(id){
    if(confirm("Are you sure you want to delete this project?")){
        fetch("delete.php",{
            method:"POST",
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`id=${id}&type=project`
        }).then(()=>location.reload());
    }
}

// Live Search
document.getElementById("searchInput").addEventListener("input", function(){
    let query = this.value;
    fetch(`projects_actions.php?action=search&query=${encodeURIComponent(query)}`)
    .then(res => res.text())
    .then(html => {
        document.getElementById("projectsContainer").innerHTML = html;
    });
});

function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
}
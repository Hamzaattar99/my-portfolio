function openForm(isAdd = true){
    const formTitle = document.getElementById("formTitle");
    const skillId = document.getElementById("skill_id");
    const nameEn = document.getElementById("name_en");
    const nameAr = document.getElementById("name_ar");
    const level = document.getElementById("level");
    const autoTranslate = document.getElementById("autoTranslate");

    if(isAdd){
        formTitle.innerText = "Add Skill";
        skillId.value = "";
        nameEn.value = "";
        nameAr.value = "";
        level.value = "Beginner";
        autoTranslate.checked = false;
    }
}

/* Auto Translate */
document.getElementById("name_en").addEventListener("blur", function(){
    let auto = document.getElementById("autoTranslate").checked;
    let arField = document.getElementById("name_ar");
    if(auto && arField.value.trim() === ""){
        let text = this.value;
        if(text.trim() !== ""){
            fetch(`https://api.mymemory.translated.net/get?q=${encodeURIComponent(text)}&langpair=en|ar`)
            .then(res => res.json())
            .then(data => {
                arField.value = data.responseData.translatedText;
            });
        }
    }
});

/* Save */
function saveSkill(){
    let id = document.getElementById("skill_id").value;
    let en = document.getElementById("name_en").value;
    let ar = document.getElementById("name_ar").value;
    let level = document.getElementById("level").value;

    if(en === "" || ar === ""){
        alert("Please fill in both English and Arabic fields!");
        return;
    }

    fetch("skills_actions.php",{
        method:"POST",
        headers:{'Content-Type':'application/x-www-form-urlencoded'},
        body:`id=${id}&en=${en}&ar=${ar}&level=${level}`
    })
    .then(()=>location.reload());
}

/* Edit */
function editSkill(id,en,ar,level){
    openForm(false);
    document.getElementById("formTitle").innerText="Edit Skill";
    document.getElementById("skill_id").value=id;
    document.getElementById("name_en").value=en;
    document.getElementById("name_ar").value=ar;
    document.getElementById("level").value=level;
}

/* Delete */
function deleteSkill(id){
    if(confirm("Are you sure?")){
        fetch("delete.php",{
            method:"POST",
            headers:{'Content-Type':'application/x-www-form-urlencoded'},
            body:`id=${id}&type=skill`
        }).then(()=>location.reload());
    }
}

// Live Search
const searchInput = document.getElementById("searchInput");
const skillsContainer = document.getElementById("skillsContainer");

searchInput.addEventListener("input", function() {
    let query = this.value;
    fetch(`skills_actions.php?action=search&query=${encodeURIComponent(query)}`)
    .then(res => res.text())
    .then(html => {
        skillsContainer.innerHTML = html;
    });
});
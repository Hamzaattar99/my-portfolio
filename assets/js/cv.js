function generateCV() {

    let data = {
        fullName: document.getElementById("fullName").value,
        email: document.getElementById("email").value,
        phone: document.getElementById("phone").value,
        summary: document.getElementById("summary").value,
        languages: document.getElementById("languages").value,
        education: document.getElementById("education").value,
        certifications: document.getElementById("certifications").value,
        skills: skills,
        experience: experience,
        projects: projects
    };

   // Loader قبل الإرسال
document.getElementById("preview").innerHTML = `
    <div class="text-center">
        <div class="loader"></div>
        <p>Generating CV...</p>
    </div>
`;

fetch("generate_cv.php", {
    method: "POST",
    headers: {
        "Content-Type": "application/json"
    },
    body: JSON.stringify(data)
})
.then(res => res.json())
.then(data => {

    console.log("Server Response:", data);



    if (data.status === "success") {

        document.getElementById("preview").innerHTML = `
            <div class="preview-box">

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-success">
                        ✔ CV Generated Successfully
                    </span>

                    <a href="../assets/uploads/cv/cv.pdf" 
                       class="btn btn-sm btn-success" download>
                       <i class="bi bi-download"></i>
                    </a>
                </div>

                <iframe 
                    src="../assets/uploads/cv/cv.pdf?${new Date().getTime()}">
                </iframe>

            </div>
        `;
    } else {
        document.getElementById("preview").innerHTML = `
            <div class="alert alert-danger">
                Error generating CV
            </div>
        `;
    }




    
})

.catch(err => {
    console.error("Fetch Error:", err);

    document.getElementById("preview").innerHTML = `
        <div class="alert alert-danger">
            Server Error (Check Console)
        </div>
    `;
});

}


function confirmLogout(){
    if(confirm("Are you sure you want to logout?")){
        window.location.href = "logout.php";
    }
}
document.addEventListener("DOMContentLoaded", function(){

    document.querySelectorAll(".toggle-desc").forEach(btn => {

        btn.addEventListener("click", function(e){
            e.stopPropagation();

            const card = btn.closest(".card-back");
            const shortText = card.querySelector(".short");
            const fullText = card.querySelector(".full");

            const isArabic = document.documentElement.lang === 'ar';

            if(fullText.classList.contains("d-none")){

                // عرض النص الكامل
                fullText.classList.remove("d-none");
                shortText.classList.add("d-none");

                btn.innerText = isArabic ? "عرض أقل" : "Show Less";

                // تفعيل التمرير داخل الكارد
                card.style.overflowY = "auto";

            } else {

                // إخفاء النص الكامل
                fullText.classList.add("d-none");
                shortText.classList.remove("d-none");

                btn.innerText = isArabic ? "عرض المزيد" : "Show More";

                // يرجع للأعلى
                card.scrollTop = 0;
            }
        });

    });

});
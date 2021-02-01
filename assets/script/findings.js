var blocks = {
    "about-collab-title": document.querySelector(".about-collab-alone"),
    "user-block-heading": document.querySelector(".user-block"),
    "article-block-heading": document.querySelector(".article-block"),
    "highlight-block-heading": document.querySelector(".highlights-block"),
    "frame-menu-create": document.querySelector(".create-article-block"),
    "overview-block-heading": document.querySelector(".overview-block")
}

var section = "article-block-heading";

let count = 0;
for (let key in blocks) {
    let value = blocks[key];
    if (value === null) {
        continue;
    }
    value.style.display = "none";
    count++;
}

document.querySelectorAll(".choose-entry").forEach((element, index) => {
    element.addEventListener("click", (e) => {
        document.querySelectorAll(".choose-entry").forEach((choose_el, c_index) => {
            choose_el.style.width = "80%";
        });
        e.target.style.width = "83%";
        if (blocks[e.target.getAttribute("show")] !== undefined && blocks[e.target.getAttribute("show")] !== null) {
            for (let key in blocks) {
                let el = blocks[key];
                if (el === null) {
                    continue;
                }
                el.style.display = "none";
            }
            section = e.target.getAttribute("show");
            blocks[section].style.display = "";
            document.cookie = "selected_section=" + section + "; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
            axios
            .post("/forum/assets/api/set_chosen_section.php?section=" + section)
            .then((languages) => {
            
            })
            .catch(() => {
                console.debug("Prompt error");
            })
        }
    });
})

if (getCookie("selected_section").length < 1) {
    axios
    .post("/forum/assets/api/get_chosen_section.php")
    .then((data) => {
        if (data.data.length < 1) {
            section = "overview-block-heading";
        } else {
            section = data.data;
        }
        blocks[section].style.display = "";
    })
    .catch(() => {
        console.debug("Prompt error");
    })
} else {
    section = getCookie("selected_section");
    blocks[section].style.display = "";
    document.querySelectorAll(".choose-entry").forEach((choose_el, c_index) => {
        if (choose_el.getAttribute("show") == section) {
            choose_el.style.width = "83%"
        }
    });
}
var pc_findings = true;

var blocks = {
    "user-block-heading": document.querySelector(".user-block"),
    "view-block-heading": document.querySelector(".view-block"),
    "article-block-heading": document.querySelector(".article-block"),
    "highlight-block-heading": document.querySelector(".highlights-block"),
    "frame-menu-create": document.querySelector(".create-article-block"),
    "frame-menu-create-report": document.querySelector(".create-report-block"),
    "overview-block-heading": document.querySelector(".overview-block"),
    "settings-block-heading": document.querySelector(".settings-block"),
    "about-block-heading": document.querySelector(".about-block")
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

function set_section (c_section) {
    for (let key in blocks) {
        let el = blocks[key];
        if (el === null) {
            continue;
        }
        el.style.display = "none";
    }
    section = c_section;
    blocks[section].style.display = "";
    document.querySelectorAll(".choose-entry").forEach((choose_el, c_index) => {
        if (choose_el.getAttribute("show") == section) {
            choose_el.style.width = "83%"
            choose_el.style.boxShadow = "inset 0px 0px 400px 110px rgba(255, 255, 255, .1)";
        }
    });
}

document.querySelectorAll(".choose-entry").forEach((element, index) => {
    element.addEventListener("click", (e) => {
        document.querySelector(".choose-views").style.display = "none";
        document.querySelectorAll(".choose-entry").forEach((choose_el, c_index) => {
            choose_el.style.width = "";
            choose_el.style.boxShadow = "";
        });
        e.target.style.width = "83%";
        e.target.style.boxShadow = "inset 0px 0px 400px 110px rgba(255, 255, 255, .1";
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

if (window.location.toString().indexOf("select=create_article") !== -1) {
    set_section("frame-menu-create");
} else if (window.location.toString().indexOf("select=about") !== -1) {
    set_section("about-block-heading");
} else if (getCookie("selected_section").length > 3 && getCookie("selected_section") !== undefined && blocks[getCookie("selected_section")] !== null && blocks[getCookie("selected_section")] !== undefined) {
    set_section(getCookie("selected_section"));
} else {
    axios
    .post("/forum/assets/api/get_chosen_section.php")
    .then((data) => {
        if (data.data.length < 1) {
            section = "overview-block-heading";
        } else {
            if (blocks[data.data] === null || blocks[data.data] === undefined) {
                set_section("overview-block-heading");
            } else {
                set_section(data.data)
            }
        }
    })
    .catch(() => {
        console.debug("Prompt error");
    })
}

let everything_hidden = true;
for (let key in blocks) {
    let el = blocks[key];
    if (el === null) {
        continue;
    }
    if (el.style.display !== "none") {
        everything_hidden = false;
    }
}

if (everything_hidden) {
    console.debug("EVERYTHING HIDDEN")
    set_section("overview-block-heading")
}


function view (what) {    
    if (what.indexOf("articleId=") !== -1) {
        axios
        .post("/forum/assets/api/get_articleHTML.php?articleId=" + what.replace("articleId=", ""))
        .then((article_html) => {
            cur_Id = what;
            document.querySelector(".view-block").innerHTML = "";
            document.querySelector(".view-block").innerHTML = article_html.data.replace('<link rel="stylesheet" href="/forum/assets/style/pc.article.css">', "").replace("theme-main-color-1", "").replace("article-background-element", "") + "<div class='view-more' onclick='window.location = \"/forum/?" + what + "\";'>...</div>";
            document.getElementById("comment_section_" + what).remove();
        })
        .catch(() => {
            console.debug("Prompt error");
        })
    } else if (what.indexOf("userId=") !== -1) {
        axios
        .post("/forum/assets/api/get_userHTML.php?userId=" + what.replace("userId=", ""))
        .then((user_html) => {      
            cur_Id = what;
            document.querySelector(".view-block").innerHTML = "";
            document.querySelector(".view-block").innerHTML = user_html.data.replace('<link rel="stylesheet" href="/forum/assets/style/pc.user.css">', "").replace("theme-main-color-1", "").replace("user-background-element", "") + "<div class='view-more' onclick='window.location = \"/forum/?" + what + "\";'>...</div>";
            document.getElementById("comment_section_" + what).remove();
        })
        .catch(() => {
            console.debug("Prompt error");
        })
    }

    document.querySelectorAll(".choose-entry").forEach((choose_el, c_index) => {
        choose_el.style.width = "";
        choose_el.style.boxShadow = "";
    });
    document.querySelector(".choose-views").style.display = "";
    document.querySelector(".choose-views").style.width = "83%";
    document.querySelector(".choose-views").style.boxShadow = "inset 0px 0px 400px 110px rgba(255, 255, 255, .1";
    if (blocks["view-block-heading"] !== undefined && blocks["view-block-heading"] !== null) {
        for (let key in blocks) {
            let el = blocks[key];
            if (el === null) {
                continue;
            }
            el.style.display = "none";
        }
        blocks["view-block-heading"].style.display = "";
        axios
        .post("/forum/assets/api/set_chosen_section.php?section=" + section)
        .then((languages) => {
        
        })
        .catch(() => {
            console.debug("Prompt error");
        })
    }
}
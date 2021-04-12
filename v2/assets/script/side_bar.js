// HANDLE CATEGORY DISPLAY


var selected_category = "Home";
var categories = ["Home", "About", "Discussion", "Projects", "Help"]
if (window.location.hash.toString().length > 0) {
    if (categories.indexOf(window.location.hash.toString().slice(1)) != -1) {
        selected_category = window.location.hash.toString().slice(1);
    }
}

document.querySelectorAll(".category-header").forEach((element, index) => {
    element.addEventListener("click", (e) => {
        console.log(e.target.getAttribute("link"))
        e.preventDefault(); 
        window.location.hash = e.target.getAttribute("link"); 
        if (window.location.hash.toString().length > 0) {
            if (categories.indexOf(window.location.hash.toString().slice(1)) != -1) {
                selected_category = window.location.hash.toString().slice(1);
            }
        }
        console.log(selected_category)
        check_selected_category();
    });
})

function check_selected_category ()
{
    document.querySelectorAll(".category-header").forEach((element, index) => {
        element.classList.remove("category-selected");
        if (element.getAttribute("link") === selected_category) {
            element.classList.add("category-selected");
        }
    })

    document.querySelectorAll(".selectbar-page").forEach((element, index) => {
        element.style.display = "none";
        if (element.classList.contains("selectbar-" + selected_category)) {
            element.style.display = "";
        }
    })
}

check_selected_category();


// HANDLE MOBILE

var opened = true;
if (mobileCheck() === true) {
    document.querySelector(".sidebar-container").style.display = "none";
    opened = false;
    document.querySelector(".sidebar-toggle").addEventListener("click", (e) => {
        opened = true;
        document.querySelector(".sidebar-toggle").style.display = "none";
        update_sidebar_visibility();
    })
    document.querySelector(".sidebar-close").addEventListener("click", (e) => {
        opened = false;
        document.querySelector(".sidebar-toggle").style.display = "";
        update_sidebar_visibility();
    })
} else {
    document.querySelector(".sidebar-toggle").style.display = "none";
    document.querySelector(".sidebar-close").style.display = "none";
}

function update_sidebar_visibility () {
    if (opened) {
        document.querySelector(".sidebar-container").style.display = "";
    } else {
        document.querySelector(".sidebar-container").style.display = "none";
    }
}
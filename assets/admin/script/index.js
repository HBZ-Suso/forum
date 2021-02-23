var admin_element_list = {
    "reportBlock": document.querySelector(".admin-report-block"),
    "visitBlock": document.querySelector(".admin-visit-block"),
    //"userBlock": document.querySelector(".admin-user-block")
}

var current_page = 0;

var switch_page = function (offset) {
    current_page += offset;
    if (current_page > Object.keys(admin_element_list).length - 1) {
        current_page = 0;
    } else if (current_page < 0) {
        current_page = Object.keys(admin_element_list).length - 1;
    }
    document.querySelectorAll(".admin-block").forEach((element, index) => {element.style.display = "none";})
    if (admin_element_list[Object.keys(admin_element_list)[current_page]] !== null){
        admin_element_list[Object.keys(admin_element_list)[current_page]].style.display = "";
    } 
}

document.getElementById("ar").addEventListener("click", (e) => {switch_page(-1);})
document.getElementById("al").addEventListener("click", (e) => {switch_page(1);})

admin_element_list[Object.keys(admin_element_list)[current_page]].style.display = "";
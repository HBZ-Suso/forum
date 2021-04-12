document.querySelector(".main-heading-text").addEventListener("click", () => {
    window.location = "/forum/";
})



var hidden = true;
document.querySelector(".main-menu-icon").addEventListener("click", (e) => {
    if (hidden === true) {
        document.querySelector(".main-menu").style.display = "initial";
        hidden = false;
        document.querySelector(".user-settings-menu").style.display = "none";
    } else {
        document.querySelector(".main-menu").style.display = "none";
        hidden = true;
    }
})






var size_heading = () => {
    if (window.mobileCheck() !== true) {
        let font_size = Math.min(window.innerWidth / 23,  60);
        document.querySelector(".main-heading-text").style.fontSize = font_size + "px";
    }
}



if (window.mobileCheck() !== true) {
    window.onresize = size_heading;
    window.onload = size_heading;
}


document.querySelector(".main-heading-search-submit").addEventListener("click", (e) => {
    window.location = "/forum/?search=" + document.querySelector(".main-heading-search-text").value;
})
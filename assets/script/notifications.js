var error_argument = "";

function get_error_argument (location_string) {
    let new_string = location_string.slice(window.location.toString().indexOf("error=") + 6);
    if (new_string.indexOf("&") !== -1) {
        new_string = new_string.slice(0, new_string.indexOf("&"));
    }
    return new_string;
}

function show_error (error_argument, error_data) {
    console.log(error_argument, error_data)
    document.getElementById("error-box").innerHTML = `
        <div class="error-display theme-main-color-1">
            <img class="error-display-implode error-display-implode-rotate" alt="|" src="https://img.icons8.com/metro/64/000000/down-squared.png"/>
            <img class="error-display-close" alt="X" src="https://img.icons8.com/windows/64/000000/macos-close.png"/>
            <h1 class="error-display-heading">${error_data["heading"]}</h1>
            <div class="error-display-text error-display-hide-on-implode" style="display: none;">${error_data["text"]}</div>
        </div>
    `;

    document.querySelector(".error-display-implode").addEventListener("click", (e) => {
        if (!e.target.classList.contains("error-display-implode-rotate")) {
            document.querySelectorAll(".error-display-hide-on-implode").forEach((element, index) => {
                element.style.display = "none";
            })
            e.target.classList.add("error-display-implode-rotate");
        } else {
            document.querySelectorAll(".error-display-hide-on-implode").forEach((element, index) => {
                element.style.display = "";
            })
            e.target.classList.remove("error-display-implode-rotate");
        }
    })

    document.querySelector(".error-display-close").addEventListener("click", (e) => {
        document.querySelector(".error-display").style.display = "none";
    })
}

function get_error_data (error_argument) {
    axios
        .get("/forum/assets/api/get_error_argument.php?error_argument=" + error_argument)
        .then((result) => {
            show_error(error_argument, result.data);
        }, (reject) => {throw new Error(reject)})
        .catch((error) => {console.debug(error);})
}

if (window.location.toString().indexOf("error=") !== -1) {
    error_argument = get_error_argument(window.location.toString())
    get_error_data(error_argument);
}
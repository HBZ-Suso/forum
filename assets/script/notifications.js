var error_argument = "";

function get_error_argument (location_string) {
    let new_string = location_string.slice(window.location.toString().indexOf("error=") + 6);
    if (new_string.indexOf("&") !== -1) {
        new_string = new_string.slice(0, new_string.indexOf("&"));
    }
    return new_string;
}

function findGetParameter (parameterName) {
    var result = null,
        tmp = [];
    location.search
        .substr(1)
        .split("&")
        .forEach(function (item) {
          tmp = item.split("=");
          if (tmp[0] === parameterName) result = decodeURIComponent(tmp[1]);
        });
    return result;
}


function show_error (error_argument, error_data) {
    console.log(error_argument, error_data)
    
    get_text("error-report-submit").then((er_rep_submit) => {
        document.getElementById("error-box").innerHTML = `s
            <div class="error-display theme-main-color-1">
                <img class="error-display-implode error-display-implode-rotate" alt="|" src="/forum/assets/img/icon/down-squared.png"/>
                <img class="error-display-close" alt="X" src="/forum/assets/img/icon/macos-close.png"/>
                <h1 class="error-display-heading">${error_data["heading"]}</h1>
                <div class="error-display-text error-display-hide-on-implode" style="display: none;">${error_data["text"]}</div>
                
                <div class="error-display-report error-display-hide-on-implode hiddennstuff" style="display: none;">
                    <textarea class="error-display-hide-until-mail error-display-report-text theme-main-color-2" style="display: none;" placeholder=''></textarea>
                    <input type="submit" class="error-display-hide-until-mail error-display-report-submit theme-main-color-2 hover-theme-main-color-2" style="display: none;" value='${er_rep_submit}'>
                </div>

                <img class="error-display-report-icon error-display-hide-on-implode" style="display: none;" alt="M"  src="/forum/assets/img/icon/apple-mail.png"/>
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

        document.querySelector(".error-display-report-icon").addEventListener("click", (e) => {
            if (e.target.style.display !== "none") {
                document.querySelectorAll(".error-display-hide-until-mail").forEach((element, index) => {
                    element.style.display = "";
                })
                document.querySelector(".error-display-report").classList.remove("hiddennstuff");
                e.target.style.display = "none";
                e.target.classList.add("hiddnnsstuff");
                e.target.classList.remove("error-display-hide-on-implode");
            }
        })

        document.querySelector(".error-display-close").addEventListener("click", (e) => {
            document.querySelector(".error-display").style.display = "none";
        })

        get_text("error-report-text").then((er_rep_text) => {
            document.querySelector(".error-display-report-text").placeholder = er_rep_text;
        }, (reject) => {throw new Error(reject)}).catch((e) => {console.debug(e)})

        document.querySelector(".error-display-report-submit").addEventListener("click", (e) => {
            document.querySelector(".error-display").style.display = "none";
            axios
                .post("/forum/assets/api/create_report.php", "form=true&title=ERRORREPLY&text=" +  encodeURI(JSON.stringify({"information": {"page": window.location.toString(), "time": Date.now(), "errorId": findGetParameter("errorId")} , "text": document.querySelector(".error-display-report-text").value})).replace("&", "-|-AND-|-"))
                .then((response) => {
                }, (reject) => {throw new Error(reject)})
                .catch((error) => {
                    console.debug(error);
                })
        })
    }, (reject) => {throw new Error(reject)}).catch((e) => {console.debug(e)})
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
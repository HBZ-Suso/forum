var t_stage = 0;
var max_stage = 2;
var text = {
    deutsch: {
        "v2-tutorial-exit": "Bedingungen akzeptieren &  schlie­ßen",
        "v2-tutorial-welcome": "Willkommen im HBZ-Forum!",
        "v2-tutorial-welcome-text": "Dieses Forum wurde erstellt, um aktuellen und ehemaligen Schüler*innen des HBZ, Lehrpersonen sowie anderen Interessierten eine Plattform zum gegenseitigen Austausch zu geben. <br>Es kann ohne Account verwendet werden. Um Artikel zu schreiben oder Kommentare zu verfassen, müssen Sie jedoch registriert sein. Sie können sich registrieren, indem Sie bei der HBZ-Leitung nach einem <a href='mailto: HBZ@suso.schulen.konstanz.de'>Account-Code fragen</a> und diesen dann im Registrierungs-Formular eingeben. Bitte teilen Sie uns bei der Anfrage auch Ihren Bezug zum HBZ mit. <br>Wenn Sie irgendwelche Fragen / Anmerkungen haben, können Sie uns jederzeit per Mail oder Meldungen-Formular kontaktieren.",
        "v2-tutorial-policies": "Nutzungsbedingungen",
        "v2-tutorial-policies-text": "Um die Website optimieren zu können, verwenden wir auf dieser Seite mehrere Varianten von Tracking sowie Cookies. Durch das Verwenden dieser Website stimmen Sie unseren Nutzungsbedingungen sowie unserer Cookie-Policy zu. Im Folgenden können Sie einige Einstellungen im Bezug auf das Tracking / die Optimierung der Website setzen.",
        "v2-tutorial-policies-science-heading": "Optimierung",
        "v2-tutorial-policies-science": "Erlauben Sie uns, Ihr Nutzungsverhalten zu analysieren und so die Website weiter zu verbessern. Dadurch würden regelmäßig ihre Verwendungsdaten zu unseren Servern gesendet werden.",
        "v2-tutorial-cookie-summary": "Cookie-Informationen",
        "v2-tutorial-policy-summary": "Nutzungsbedingungen",
        "v2-tutorial-licence-summary": "Lizenz",
    },
    english: {
        "v2-tutorial-exit": "Accept conditions & Exit",
        "v2-tutorial-welcome": "Welcome to the HBZ-Forum!",
        "v2-tutorial-welcome-text": "This Forum has been created in order for students, teachers, alumnus and others to be able to get into contact to each other and exchange themselves about different subjects. <br>It can be used and browsed without an account. If you, however, want to be able to post articles or comments you need to be registered. You can register as soon as you have an Account-Code which you can receive from the HBZ-Team.<br>If you have any questions feel free to contact us per Report.",
        "v2-tutorial-policies": "Policies",
        "v2-tutorial-policies-text": "In order to optimise the webpage further we are colecting personal user data and habits. We only use them in order for us to be able to improve our service and wont hand them over to 3rd party actors.",
        "v2-tutorial-policies-science-heading": "Optimization",
        "v2-tutorial-policies-science": "Allow us to regularily send personal usability data to our servers for us to analyse.",
        "v2-tutorial-cookie-summary": "Cookie-Information",
        "v2-tutorial-policy-summary": "Terms of use",
        "v2-tutorial-licence-summary": "Licence",
    }
}
var selected_text = text["deutsch"];
var current_language = "deutsch";





window.addEventListener("load", () => {
    if (getCookie("language").length > 1 && getCookie("language") in text) {
        current_language = getCookie("language");
        selected_text = text[getCookie("language")];
    }

    let mobile_css = '';
    if (window.mobileCheck()) {
        mobile_css = '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.tutorial.css">';
    }

    let tutorialContainer = document.createElement("div");
    document.body.appendChild(tutorialContainer);
    tutorialContainer.classList.add("tutorial-container")
    tutorialContainer.innerHTML = `
        <link rel="stylesheet" href="/forum/v2/assets/style/tutorial.css">
        <div class="tutorial-innerContainer">
            <div class="tutorial-exit" onclick="tutorial_exit();">${selected_text["v2-tutorial-exit"]}</div>
            <div class="tutorial-innerInnerContainer">
                
            </div>
            <div class="tutorial-back" onclick="if (t_stage > 0) {t_stage -= 1}; tutorial_show();"><img src="/forum/assets/img/icon/arrow.png"></div>
            <div class="tutorial-continue" onclick="if (t_stage < max_stage) {t_stage++; tutorial_show();} else if (this.innerHTML.indexOf('<img src=') === -1) {tutorial_exit();}"><img src="/forum/assets/img/icon/arrow.png"></div>
        </div>
        ${mobile_css}
    `;

    tutorial_show();
})



function tutorial_show () {
    document.querySelector(".tutorial-exit").innerHTML = selected_text["v2-tutorial-exit"];
    if (t_stage === max_stage) {document.querySelector(".tutorial-continue").innerHTML = selected_text["v2-tutorial-exit"];} else {document.querySelector(".tutorial-continue").innerHTML = '<img src="/forum/assets/img/icon/arrow.png">';}
    if (t_stage === 0) {document.querySelector(".tutorial-back").style.display = "none";} else {document.querySelector(".tutorial-back").style.display = "";}
    if (t_stage === max_stage) {
        document.querySelector(".tutorial-exit").style.display = "none";
        document.querySelector(".tutorial-innerInnerContainer").style.top = "10px";
    } else {
        document.querySelector(".tutorial-exit").style.display = "";
        document.querySelector(".tutorial-innerInnerContainer").style.top = "";
    }

    switch (t_stage) {
        case 0:
            document.querySelector(".tutorial-innerInnerContainer").innerHTML = `
                <h1>Sprache / Language</h1>

                <div class="wrapper">
                    <input type="radio" name="select" id="option-1" class="tutorial-language-deutsch">
                    <input type="radio" name="select" id="option-2" class="tutorial-language-english">
                    <!-- <input type="radio" name="select" id="option-3">-->
                    <label for="option-1" class="tutorial-language-option option option-1" lang="deutsch">
                        <div lang="deutsch" class="dot"></div>
                        <span lang="deutsch">Deutsch</span>
                    </label>
                    <label for="option-2" class="tutorial-language-option option option-2" lang="english">
                        <div lang="english" class="dot"></div>
                        <span lang="english">English</span>
                    </label>
                    <!-- 
                    <label for="option-3" class="tutorial-language-option option option-3">
                        <div class="dot"></div>
                        <span>Teacher</span>
                    </label>
                    -->
                </div>

                <p class="tutorial-tip">Verwenden Sie diese Einstellung, um die Website auf Ihre bevorzugte Sprache umzustellen / Use this to change the webpage to your preferred language</p>
            `;

            language_dropdown();
            break;
        case 1:
            document.querySelector(".tutorial-innerInnerContainer").innerHTML = `
                <h1>${selected_text["v2-tutorial-welcome"]}</h1>

                <p class="tutorial-text">${selected_text["v2-tutorial-welcome-text"]}</p>
            `;
            break;
        case 2:
            document.querySelector(".tutorial-innerInnerContainer").innerHTML = `
                <h1>${selected_text["v2-tutorial-policies"]}</h1>

                <p class="tutorial-text">${selected_text["v2-tutorial-policies-text"]}</p>


                <details class="tutorial-cookie-summary">
                <summary>${selected_text["v2-tutorial-cookie-summary"]}</summary>
                </details>

                <details class="tutorial-policy-summary">
                <summary>${selected_text["v2-tutorial-policy-summary"]}</summary>
                </details>

                <!--details class="tutorial-licence-summary">
                <summary>${selected_text["v2-tutorial-licence-summary"]}</summary>
                </!--details>
                <div class="tutorial-space"></div>-->

                <h2>${selected_text["v2-tutorial-policies-science-heading"]}</h2>
                <p class="tutorial-text">${selected_text["v2-tutorial-policies-science"]}</p>
                <div class="wrapper tutorial-logs">
                    <input type="radio" name="select" id="option-1" class="tutorial-logs-on">
                    <input type="radio" name="select" id="option-2" class="tutorial-logs-off">
                    <label for="option-1" class="tutorial-logs-option option option-1" value="on">
                        <div value="on" class="dot"></div>
                        <span value="on">Erlauben</span>
                    </label>
                    <label for="option-2" class="tutorial-logs-option option option-2" value="off">
                        <div value="off" class="dot"></div>
                        <span value="off">Verhindern</span>
                    </label>
                </div>


                <div class="tutorial-space"></div>
            `;

            policy_select();

            break;
    }
}



function tutorial_exit () {
    document.cookie = "policy-agreed=true; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
    document.querySelector(".tutorial-container").remove();
}


function language_dropdown () {
    document.querySelectorAll(".tutorial-language-option").forEach((element, index) => {
        if (current_language === element.getAttribute("lang")) {
            document.querySelector(".tutorial-language-" + current_language).checked = true;
        } else {
            document.querySelector(".tutorial-language-" + element.getAttribute("lang")).checked = false;
        }
        element.addEventListener("click", (e) => {
            current_language = e.target.getAttribute("lang");

            selected_text = text[current_language];
            set_language(e.target.getAttribute("lang"));

            if (t_stage === 0) {
                t_stage += 1;
                tutorial_show();
            }
        })
    })
}


function policy_select () {
    if (getCookie("science").length > 0 && getCookie("science") === "off") {
        document.querySelector(".tutorial-logs-off").checked = true;
        document.querySelector(".tutorial-logs-on").checked = false;
    } else {
        document.querySelector(".tutorial-logs-on").checked = true;
        document.cookie = "science=on; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
    }
    

    document.querySelectorAll(".tutorial-logs-option").forEach((element, index) => {
        element.addEventListener("click", (e) => {
            document.cookie = "science=" + element.getAttribute("value") + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
        })
    })


    axios
        .post("/forum/v2/assets/api/policy.php")
        .then((resolve) => {
            document.querySelector(".tutorial-cookie-summary").innerHTML += resolve.data["cookie"];
            document.querySelector(".tutorial-policy-summary").innerHTML += resolve.data["privacy"];
            document.querySelector(".tutorial-licence-summary").innerHTML += resolve.data["licence"];
        })
}
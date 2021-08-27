if (getCookie("vprhe").length > 0) {
    var hash_history = JSON.parse(getCookie("vprhe"));
} else {
    var hash_history = [];
}

var full_pages = ["Home", "About", "Discussion", "Projects", "Help"];
if (localStorage.getItem("logs") === null) {
    localStorage.setItem("logs", JSON.stringify([]));
}


function add_log (content) {
    if (getCookie("science") === "off") {return;}
    let log = JSON.parse(localStorage.getItem("logs"));
    log.push({"date": Date.now(), "content": content})
    localStorage.setItem("logs", JSON.stringify(log));
}

function add_hash_to_history () {
    hash_history.push({"time": Date.now(), "state": window.location.hash})
    if (hash_history.length > 20) {
        hash_history.reverse().pop();
        hash_history.reverse();
    }
    document.cookie = "vprhe=" + JSON.stringify(hash_history) + "; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 

    add_log({"type": "hash", "data": {"time": Date.now(), "state": window.location.hash}});
}

function check_hash_usage () {
    try {
        let lhash = hash_history[hash_history.length - 1]["state"];
        if (lhash.indexOf("?") !== -1) {
            lhash = lhash.slice(0, (lhash.indexOf("?")));
        }
        if (document.querySelector(".hashLoadedPage").innerText !== lhash.replace("#", "") || hash_history[hash_history.length - 1]["state"] !== hash_history[hash_history.length - 2]["state"]) {
            // Both as with ?something=something it isnt saved in hashLoadedPage
            issue_commands_after_hash(hash_history[hash_history.length - 1]["state"])
        }
    } catch (e) {
        console.debug(e)
    }
}

function find_last_category () {
    console.debug("Using find_last_category...")
    for (let i=0; true; i++) {
        if (i + 1 > hash_history.length) {
            console.debug("No usable page found... Setting to default (Home)")
            return "Home";
        }

        if (full_pages.indexOf(hash_history[hash_history.length - 1 - i]["state"].replace("#", "")) !== -1) {
            return hash_history[hash_history.length - 1 - i]["state"].replace("#", "");
        }
    }
}


var hashTree = {
    Login: () => {show_login_and_logout()},
    Signup: () => {show_signup()},
    Settings: () => {show_settings()},
    Article: () => {show_article()},
    Profile: () => {show_profile(window.location.toString().slice(window.location.toString().indexOf("?userId=") + 8));},
    CreatePost: () => {show_create_post(find_last_category());},
    Report: () => {report(additional_info="-|-HASH-|-" + window.location.hash + "-|-HASH-|-")},
    Administration: () => {show_administration()},
    Information: () => {show_webpage_info()},
    ProfilePicture: () => {profilepicture.show_profilepicture()}
}

var embed = false;
function issue_commands_after_hash (hash) {
    if (hash.indexOf("?") !== -1) {
        hash = hash.slice(0, (hash.indexOf("?")));
    }

    if (window.location.toString().indexOf("?embed") !== -1) {
        embed = true;
    } else {
        embed = false;
    }
 
    try {
        //console.log(hashTree[hash.replace("#", "")],hash.replace("#", ""));
        hashTree[hash.replace("#", "")]();
    } catch (e) {
        console.debug(`Error whilst issuing internal ${hash} command, Error: `, e)
        hashchange_error(e);

        try {close_login_window();} catch (e) {}
        try {close_settings_window();} catch (e) {}
        try {close_article_if_not_side_by_side();} catch (e) {}
        try {close_createpost_window();} catch (e) {}
    }
}

if (window.location.hash.length > 0) {
    add_hash_to_history();
    function language_loaded () {
        issue_commands_after_hash(hash_history[hash_history.length - 1]["state"]);
    }
} else {
    function language_loaded () {
        console.debug("Hashhistory empty...")
    }
}

window.addEventListener("hashchange", (e) => {
    add_hash_to_history();
    check_hash_usage();
})



function hashchange_error (error) {
    window.location.hash = find_last_category();
}
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
        if (hash_history[hash_history.length - 1]["state"] !== hash_history[hash_history.length - 2]["state"]) {
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


function issue_commands_after_hash (hash) {
    if (hash.indexOf("?") !== -1) {
        hash = hash.slice(0, (hash.indexOf("?")));
    }
    switch (hash) {
        case "#Login":
            try {
                show_login_and_logout();
            } catch (e) {
                console.debug("Error whilst issuing internal Login command, Error: ", e)
            }
            break;
        case "#Signup":
            try {
                show_signup();
            } catch (e) {
                console.debug("Error whilst issuing internal Login command, Error: ", e)
            }
            break;
        case "#Settings":
            try {
                show_settings();
            } catch (e) {
                console.debug("Error whilst issuing internal Settings command, Error: ", e)
            }
            break;
        case "#Article":
            try {
                show_article();
            } catch (e) {
                console.debug("Error whilst issuing internal Article command, Error: ", e)
            }
            break;
        case "#Profile":
            try {
                show_profile(window.location.toString().slice(window.location.toString().indexOf("?userId=") + 8));
                /*
                window.open("/forum/v2/?site=profile&" + window.location.toString().slice(window.location.toString().indexOf("?userId=") + 1), "Profile", "width=800,height=800,fullscreen=false,location=false,menubar=false,resizable=false,status=false,titlebar=false,toolbar=false", false)

                // Sets hash back to last before article view 
                for (let i=0; i < hash_history.length; i++) {
                    if (hash_history[i]["state"].indexOf("Profile") === -1) {
                        window.location.hash = hash_history[i]["state"];
                        break;
                    }
                }*/
            } catch (e) {
                console.debug("Error whilst issuing internal Profile command, Error: ", e)
            }
            break;
        case "#CreatePost":
            try {
                show_create_post(find_last_category());
            } catch (e) {
                console.debug("Error whilst issuing internal Createpost command, Error: ", e)
            }
            break;
        case "#Report":
            try {
                report(additional_info="-|-HASH-|-" + window.location.hash + "-|-HASH-|-")
            } catch (e) {
                console.debug("Error whilst issuing internal Report command, Error: ", e)
            }
            break;
        case "#Information":
            try {
                show_webpage_info();
            } catch (e) {
                console.debug("Error whilst issuing internal Information command, Error: ", e)
            }
            break;
        case "#Administration":
            try {
                show_administration();
            } catch (e) {
                console.debug("Error whilst issuing internal Administration command, Error: ", e)
            }
            break;
        default:
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
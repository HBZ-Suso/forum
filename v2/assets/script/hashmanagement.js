if (getCookie("vprhe").length > 0) {
    var hash_history = JSON.parse(getCookie("vprhe"));
} else {
    var hash_history = [];
}


function add_hash_to_history () {
    hash_history.push({"time": Date.now(), "state": window.location.hash})
    if (hash_history.length > 20) {
        hash_history.reverse().pop();
        hash_history.reverse();
    }
    document.cookie = "vprhe=" + JSON.stringify(hash_history) + "; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
}

function check_hash_usage () {
    if (hash_history[hash_history.length - 1]["state"] != hash_history[hash_history.length - 2]["state"]) {
        issue_commands_after_hash(hash_history[hash_history.length - 1]["state"])
    }
}

function issue_commands_after_hash (hash) {
    switch (hash) {
        case "#Login":
            try {
                show_login_and_logout();
            } catch (e) {
                console.debug("Error whilst issuing internal Login command, Error: " + e)
            }
            break;
        case "#Settings":
            try {
                show_settings();
            } catch (e) {
                console.debug("Error whilst issuing internal Settings command, Error: " + e)
            }
            break;
    }
}

if (window.location.hash.length > 0) {
    add_hash_to_history();
    window.addEventListener("load", (e) => {
        issue_commands_after_hash(hash_history[hash_history.length - 1]["state"]);
    });
}

window.addEventListener("hashchange", (e) => {
    add_hash_to_history();
    check_hash_usage();
})
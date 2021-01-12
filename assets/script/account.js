var changed = {};
var elements = [
    document.getElementById("userDescription"),
    document.getElementById("userPhone"),
    document.getElementById("userEmployment"),
    document.getElementById("userMail"),
    document.getElementById("userAge")
]

function send_ajax () {
    ajax_request = "change_data=" +  JSON.stringify(changed);
    axios
        .post("/forum/assets/api/change_data.php", ajax_request)
        .then((response) => {
            reload.changed = false;
            document.getElementById("userSubmit").style.backgroundColor = "green";
            setTimeout(() => {document.getElementById("userSubmit").style.backgroundColor = ""}, 1500);
        })
        .catch((error) => {
            console.debug(error);
            
        })
}

var timeout = 5;

var reload = {
    changed: false,
    execute: function () {
        this.changed = true;
    }
}

elements.forEach((element, index) => {
    element.value = user_data[element.id];
    if (element !== null) {
        element.addEventListener("keyup", (e) => {
            changed[e.target.id] = e.target.value;
            if (e.target.value === user_data[e.target.id]) {
                delete changed[e.target.id];
            }
            reload.execute();
        });
        element.addEventListener("change", (e) => {
            changed[e.target.id] = e.target.value;
            if (e.target.value === user_data[e.target.id]) {
                delete changed[e.target.id];
            }
            reload.execute();
        })
    }
})



document.getElementById("userAge").addEventListener("keyup", (e) => {
    if (isNaN(e.target.value)) {
        if (!isNaN(user_data["userAge"])) {
            e.target.value = user_data["userAge"];
        } else {
            e.target.value = "20";
        }
    }
})
document.getElementById("userAge").addEventListener("change", (e) => {
    if (isNaN(e.target.value)) {
        if (!isNaN(user_data["userAge"])) {
            e.target.value = user_data["userAge"];
        } else {
            e.target.value = "20";
        }
    }
})



document.getElementById("userSubmit").addEventListener("click", (e) => {
    e.preventDefault();

    send_ajax();
})



var timer = () => {
    if (reload.changed == true) {
        send_ajax();
    }
    setTimeout(() => {timer()}, 1000 * timeout);
}

timer();
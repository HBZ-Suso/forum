var changed = {};
var elements = [
    document.getElementById("userDescription"),
    document.getElementById("userPhone"),
    document.getElementById("userEmployment"),
    document.getElementById("userMail"),
    document.getElementById("userAge")
]

var timeout = 20;

var reload = {
    reloading: false,
    execute: function () {
        if (reload.reloading === false) {
            setTimeout(function () {document.getElementById("main_form").submit();}, timeout * 1000);
            reload.reloading = true; 
            document.getElementById("counter").innerText = timeout;
            setTimeout(reload.update_timer, 1000);
        }
    },
    update_timer: function () {
        document.getElementById("counter").innerText = parseInt(document.getElementById("counter").innerText) - 1;
        if (parseInt(document.getElementById("counter").innerText) < 0) {
            document.getElementById("counter").innerText = 20;
            document.getElementById("counter").style.backgroundColor = "aquamarine";
        } else {
            if (parseInt(document.getElementById("counter").innerText) > 10) {
                document.getElementById("counter").style.backgroundColor = "orange";
            } else {
                document.getElementById("counter").style.backgroundColor = "red";
            }
            setTimeout(reload.update_timer, 1000);
        } 
    }
}

elements.forEach((element, index) => {
    element.value = user_data[element.id];
    if (element !== null) {
        element.addEventListener("keyup", (e) => {
            changed["selected"] = e.target.id;
            changed[e.target.id] = e.target.value;
            if (e.target.value === user_data[e.target.id]) {
                delete changed[e.target.id];
            }
            document.getElementById("change_data").value = JSON.stringify(changed);
            reload.execute();
        });
        element.addEventListener("change", (e) => {
            changed["selected"] = e.target.id;
            changed[e.target.id] = e.target.value;
            if (e.target.value === user_data[e.target.id]) {
                delete changed[e.target.id];
            }
            document.getElementById("change_data").value = JSON.stringify(changed);
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


if (selected !== undefined) {
    document.getElementById(selected).click();
    document.getElementById(selected).focus();
}
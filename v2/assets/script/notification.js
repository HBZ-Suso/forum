window.onload = function () {
    if (logged_in) {
        axios
            .post("/forum/v2/assets/api/get_notifications.php")
            .then((resolve) => {
                update_notifications(resolve.data)
            }, (reject) => {throw new Error(reject);})
            .catch((e) => console.debug)
    }

    connection.functions.push(function () {
        if (logged_in) {
            axios
            .post("/forum/v2/assets/api/get_notifications.php")
            .then((resolve) => {
                update_notifications(resolve.data);
            }, (reject) => {throw new Error(e)})
            .catch((e) => console.debug)
        }
    })
}




function read_notification (notificationId) {
    axios
        .post("/forum/v2/assets/api/read_notification.php?notificationId=" + notificationId)
        .then((resolve) => {
            if (resolve.data.indexOf("error") === -1) {
                document.querySelector(".notification-element-side-id-" + notificationId).classList.remove("notification-element-side-new");
                update_unread_counter();
            }
        }, (reject) => {throw new Error(reject);})
        .catch((e) => console.debug)
}



function update_unread_counter () {
    let counter = 0;
    
    for (var i = 0; i < document.querySelector(".notification-container").children.length; i++) {
        if (document.querySelector(".notification-container").children[i].children[3].classList.contains("notification-element-side-new")) {
            counter++;
        }
    }
    document.querySelector(".userview-notifications-new").innerHTML = counter;

    if (parseInt(document.querySelector(".userview-notifications-new").innerHTML) < 1) {
        document.querySelector(".userview-notifications-new").style.display = "none";
    } else {
        document.querySelector(".userview-notifications-new").style.display = "";
    }
}

function toggle_notification_sidebar () {
    if (document.querySelector('.notification-container').classList.contains("notification-container-hidden")) {
        add_log({"type": "notificationSideBar", "data": {"time": Date.now(), "state": true}});
        document.querySelector('.notification-container').classList.remove("notification-container-hidden")
    } else {
        add_log({"type": "notificationSideBar", "data": {"time": Date.now(), "state": false}});
        document.querySelector('.notification-container').classList.add("notification-container-hidden")
    };
}



function update_notifications (data) { 
    if (parseInt(document.querySelector(".notification-container").getAttribute("dataLength")) !== parseInt(data.length)) {
        document.querySelector(".notification-container").innerHTML = '';
        data.sort((a, b) => {return (b["notificationDate"] - a["notificationDate"]);})
        while (data.length > 30) {
            data.pop();
        }
        data.forEach((element, index) => {
            let title = get_notification_title(element.notificationType);
            let creation_date = new Date(element.notificationDate * 1000);
            let hours = creation_date.getHours().toString();
            if (hours.length <= 1) {
                hours = "0" + hours;
            }
            let minutes = creation_date.getMinutes().toString();
            if (minutes.length <= 1) {
                minutes = "0" + minutes;
            }
            let read = "";
            if (element.notificationRead !== 1) {
                read = "notification-element-side-new";
            }
            if (title.length > 0) {
                document.querySelector(".notification-container").innerHTML += `
                <div class="notification-element">
                    <p class="notification-element-heading">${title}</p>
                    <p class="notification-element-time">${ordinal_suffix_of(creation_date.getDate())} ${get_month_name(creation_date.getMonth() + 1)} ${creation_date.getFullYear()}, ${hours}:${minutes}</p>
                    <p class="notification-element-description">${convert_description_placeholder(element.notificationDescription)}</p>
                    <div class="notification-element-side-id-${element.notificationId} notification-element-side ${read}" onclick="read_notification(${element.notificationId}); notification_link('${element.notificationLink}');"></div>
                </div>
                `;
            }
        })
        document.querySelector(".notification-container").setAttribute("dataLength", data.length)
        update_unread_counter();
        let new_data = data.filter((element) => {return (element.notificationRead === 0);})
        if (new_data.length > 0) {
            show_notification_popup(new_data.sort((a, b) => {return (a["notificationDate"] < b["notificationDate"]);})[0]);
        }
    }
}


function show_popup (title, time, text, link=false) {
    if (time === "current") {
        let creation_date = new Date();
        let hours = creation_date.getHours().toString();
        if (hours.length <= 1) {
            hours = "0" + hours;
        }
        let minutes = creation_date.getMinutes().toString();
        if (minutes.length <= 1) {
            minutes = "0" + minutes;
        }

        time = `${ordinal_suffix_of(creation_date.getDate())} ${get_month_name(creation_date.getMonth() + 1)} ${creation_date.getFullYear()}, ${hours}:${minutes}`;
    }

    document.querySelector(".notification-new").innerHTML = `
    <p class="notification-new-heading">${title}</p>
    <p class="notification-new-time">${time}</p>
    <p class="notification-new-description">${text}</p>
    `;
    document.querySelector(".notification-new").classList.add("notification-new-show");
    setTimeout(() => {
        document.querySelector(".notification-new").classList.remove("notification-new-show");
    }, 5000);
    if (link !== false) {
        document.querySelector(".notification-new").addEventListener("click", link)
    }
}


function show_notification_popup (data) {
    let title = get_notification_title(data.notificationType);
    let creation_date = new Date(data.notificationDate * 1000);
    let hours = creation_date.getHours().toString();
    if (hours.length <= 1) {
        hours = "0" + hours;
    }
    let minutes = creation_date.getMinutes().toString();
    if (minutes.length <= 1) {
        minutes = "0" + minutes;
    }
    let read = "";
    if (data.notificationRead !== 1) {
        read = "notification-element-side-new";
    }
   
    show_popup(
        title, 
        `${ordinal_suffix_of(creation_date.getDate())} ${get_month_name(creation_date.getMonth() + 1)} ${creation_date.getFullYear()}, ${hours}:${minutes}`,
        convert_description_placeholder(data.notificationDescription),
        function () {
            document.querySelector(".notification-new").classList.remove("notification-new-show");
            read_notification(data.notificationId);
            notification_link(data.notificationLink);
        }
    );

    add_log({"type": "notificationPopup", "data": {"time": Date.now(), "notificationId": data.notificationId}});
}

function get_notification_title (type) {
    switch (type) {
        case 0:
            title = language_data["v2-notification-title-article-liked"];
            break;
        case 1:
            title = language_data["v2-notification-title-profile-liked"];
            break;
        case 2:
            title = language_data["v2-notification-title-article-commented"];
            break;
        case 3:
            title = language_data["v2-notification-title-profile-commented"];
            break;
        case 4:
            title = language_data["v2-notification-title-profile-posted"];
            break;
        case 5:
            title = language_data["v2-notification-title-settings-changed"];
            break;
        case 6:
            title = language_data["v2-notification-title-password-changed"];
            break;
        case 7:
            title = language_data["v2-notification-title-account-linked"];
            break;
        case 8:
            title = language_data["v2-notification-title-account-verified"];
            break;
        case 9:
            title = language_data["v2-notification-title-account-locked"];
            break;
        case 10:
            title = language_data["v2-notification-title-password-reset"];
            break;
        case 11:
            title = language_data["v2-notification-title-article-published"];
            break;
        case 12:
            title = language_data["v2-notification-title-account-unlocked"];
            break;
        case 13:
            title = language_data["v2-notification-title-account-created"];
            break;
        case 14:
            title = language_data["v2-notification-title-report-sent"];
            break;
        case 15:
            title = language_data["v2-notification-title-article-deleted"];
            break;
        case 16:
            title = language_data["v2-notification-title-article-pinned"];
            break;
        case 17:
            title = language_data["v2-notification-title-message-received"];
            break;
        default:
            return;
    }
    return title;
}



function convert_description_placeholder (text) {
    [
        "liked",
        "commented",
        "commentedProfile",
        "posted",
        "settingschanged",
        "passwordchanged",
        "verified",
        "locked",
        "locked",
        "unlocked",
        "passwordreset",
        "publishedarticle1",
        "publishedarticle2",
        "accountcreated",
        "reportsent",
        "articledeleted",
        "notification",
        "public",
        "pinned",
        "messaged"
    ].forEach((element, index) => {
        text = text.replace("{{" + element + "}}", language_data["v2-notification-placeholder-" + element])
    })
    return text;
}




function notification_link  (link) {
    if (link.indexOf("-|-openchat") !== -1) {
        link = link.replace("-|-openchat**", "").replace("-|-", "")
        chat.open_chat(parseInt(link));
    } else {
        window.location = link;
    }
}
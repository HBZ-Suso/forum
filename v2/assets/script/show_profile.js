function show_profile (userId) {
    axios
        .post("/forum/assets/api/get_user.php?userId=" + userId)
        .then((resolve) => {
            try {
                if (resolve.data.indexOf("Permissionerror") !== -1) {
                    window.location.hash = find_last_category();
                    return;
                }
            } catch (e) {}; // Data is JSON

            /*
            let login_window = document.createElement("div");
            login_window.classList.add("loginbox-container")
            document.body.appendChild(login_window);*/

            let add_mobile_profilebox_stylesheet = '';
            if (window.mobileCheck() == true) {
                add_mobile_profilebox_stylesheet = '<link rel="stylesheet" href="/forum/v2/assets/style/mobile.profilebox.css">';
            }

            let verified = '';

            if (parseInt(resolve.data.userVerified) === 1) {
                verified = `<img src="/forum/assets/img/icon/verified_black_24dp.svg" class="profilebox-verified">`;
            }
            
            show_article(custum_html=true, heading=language_data["v2-profilebox-heading"], content_html=`
                <div class="profilebox">

                    <div class="profilebox-bar">
                        <img src="/forum/assets/img/icon/user.svg" class=" author-profile-color-overlay-${resolve.data.color}">
                        <div class="profilebox-bar-bar">
                            <img src="/forum/assets/img/icon/favorite_border_black_24dp.svg" class="profilebox-bar-like">
                            <h1>${resolve.data.userName}</h1>
                            ${verified}
                        </div>
                    </div>

                    <div class="profilebox-column profilebox-column-left">
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-email-heading"] + "</p>" + resolve.data.userMail}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-phone-heading"] + "</p>" + resolve.data.userPhone}</div>

                        <div class="profilebox-info-column"><p>${language_data["v2-profile-author-of-1"] + "</p>" + resolve.data.articles + "<p>" + language_data["v2-profile-author-of-2"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-opened-articles-1"] + "</p>" + resolve.data.articleViews + "<p>" + language_data["v2-profile-articles"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-liked-articles-1"] + "</p>" + resolve.data.articleLikes + "<p>" + language_data["v2-profile-articles"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-commented-1"] + "</p>" + resolve.data.articleComments + "<p>" + language_data["v2-profile-commented-2"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-created-1"] + "</p>" + get_days_old(resolve.data.userCreated) + "<p>" + language_data["v2-profile-days-old"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-article-created"] + "</p>" + get_days_old(resolve.data.userLastArticle * 1000) + "<p>" + language_data["v2-profile-days-ago"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-comment-created"] + "</p>"  + get_days_old(resolve.data.userLastComment * 1000) + "<p>" + language_data["v2-profile-days-ago"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-opened-1"] + "</p><span class='profilebox-info-column-userviews'>" + resolve.data.userViews + "</span><p>" + language_data["v2-profile-opened-2"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-liked-1"] + "</p><span class='profilebox-info-column-userlikes'>" + resolve.data.userLikes + "</span><p>" + language_data["v2-profile-liked-2"] + "</p>"}</div>
                        <div class="profilebox-info-column"><p>${language_data["v2-profile-comments-1"] + "</p>" + resolve.data.userComments + "<p>" + language_data["v2-profile-comments-2"] + "</p>"}</div>
                    </div>

                    <div class="profilebox-column profilebox-column-right">
                        ${resolve.data.userDescription}
                    </div>

                <link rel="stylesheet" href="/forum/v2/assets/style/profilebox.css">
                ${add_mobile_profilebox_stylesheet}
                </div>`);

                if (resolve.data.liked) {
                    document.querySelector(".profilebox-bar-like").classList.add("profilebox-bar-liked");
                    document.querySelector(".profilebox-bar-like").src = "/forum/assets/img/icon/favorite_black_24dp.svg";
                }

                document.querySelector(".profilebox-bar-like").addEventListener("click", (e) => {
                    if (logged_in) {
                        axios
                        .post("/forum/assets/api/like.php?targetUserId=" + userId)
                        .then((resolve) => {
                            if (document.querySelector(".profilebox-bar-like").classList.contains("profilebox-bar-liked")) {
                                document.querySelector(".profilebox-bar-like").classList.remove("profilebox-bar-liked");
                                document.querySelector(".profilebox-bar-like").src = "/forum/assets/img/icon/favorite_border_black_24dp.svg";
                                document.querySelector('.profilebox-info-column-userlikes').innerHTML = parseInt(document.querySelector('.profilebox-info-column-userlikes').innerHTML) - 1;
                            } else {
                                document.querySelector(".profilebox-bar-like").classList.add("profilebox-bar-liked");
                                document.querySelector(".profilebox-bar-like").src = "/forum/assets/img/icon/favorite_black_24dp.svg";
                                document.querySelector('.profilebox-info-column-userlikes').innerHTML = parseInt(document.querySelector('.profilebox-info-column-userlikes').innerHTML) + 1;
                            }
                        })
                    } else {
                        window.location.hash = "Login";
                    }
                })

                axios
                    .post("/forum/v2/assets/api/view.php?userId=" + userId)
                    .then((resolve) => {if (resolve.data.indexOf("error") === -1) {document.querySelector(".profilebox-info-column-userviews").innerText = parseInt(document.querySelector(".profilebox-info-column-userviews").innerText) + 1;}}, (reject) => {throw new Error(reject)})
                    .catch((e) => console.debug)

        }, (reject) => {
            console.debug("Error whilst trying to logout.")
        })
}


function close_profile_window () {
    let counter = -2;
    while (window.location.hash === "#Profile") {
        window.location.hash = hash_history[hash_history.length + counter]["state"].slice(1);
        counter--;
    }
    document.querySelector(".profilebox-container").remove();
}


function get_days_old (creation_date) {
    let c_date = new Date(creation_date);
    let now = new Date();
    let difference = (now.getFullYear() * 365 + get_day_of_year(now)) - (c_date.getFullYear() * 365 + get_day_of_year(c_date));
    if (difference > 0) {
        return difference;
    } else {
        return 0;
    }
}


function get_day_of_year (date_obj) {
    return (Date.UTC(date_obj.getFullYear(), date_obj.getMonth(), date_obj.getDate()) - Date.UTC(date_obj.getFullYear(), 0, 0)) / 24 / 60 / 60 / 1000;
}
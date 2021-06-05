function toggle_profile_view () {
    if (document.querySelector(".profile-middle-column").classList.contains("profile-middle-column-toggled")) {
        document.querySelector(".profile-middle-column").classList.remove("profile-middle-column-toggled");
        document.querySelector(".profile-left-column").classList.remove("profile-left-column-toggled");
        document.querySelector(".profile-right-column").classList.remove("profile-right-column-toggled");
    } else {
        document.querySelector(".profile-middle-column").classList.add("profile-middle-column-toggled");
        document.querySelector(".profile-left-column").classList.add("profile-left-column-toggled");
        document.querySelector(".profile-right-column").classList.add("profile-right-column-toggled");
        //setTimeout(function () {alert("xD");}, 200);
    }
    
}


axios
    .post("/forum/assets/api/get_user.php?transformBoolean=true&transformNull=true&userId=" + document.getElementById("profile-userId").innerText)
    .then((resolve) => {
        set_data_columns(resolve.data);
    }, (reject) => {throw new Error(reject)})
    .catch(console.debug)

function set_data_columns (data) {
    document.querySelector(".articles").innerText = language_data["v2-profile-author-of-1"] + data.articles + language_data["v2-profile-author-of-2"];
    document.querySelector(".articleViews").innerText = language_data["v2-profile-opened-articles-1"] + data.articleViews + language_data["v2-profile-articles"];
    document.querySelector(".articleLikes").innerText = language_data["v2-profile-liked-articles-1"] + data.articleLikes + language_data["v2-profile-articles"];
    document.querySelector(".articleComments").innerText = language_data["v2-profile-commented-1"] + data.articleComments + language_data["v2-profile-commented-2"];
    
    document.querySelector(".userCreated").innerText = language_data["v2-profile-created-1"] + get_days_old(data.userCreated) + language_data["v2-profile-days-old"];
    if (get_days_old(data.userCreated) == 1) {
        document.querySelector(".userCreated").innerText = language_data["v2-profile-created-1"] + get_days_old(data.userCreated) + language_data["v2-profile-day-old"];
    }

    document.querySelector(".lastArticle").innerText = language_data["v2-profile-article-created"] + get_days_old(data.userLastArticle * 1000) + language_data["v2-profile-days-ago"];
    if (get_days_old(data.userLastArticle * 1000) == 1) {
        document.querySelector(".lastArticle").innerText = language_data["v2-profile-article-created"] + get_days_old(data.userLastArticle * 1000) + language_data["v2-profile-day-ago"];
    }

    document.querySelector(".lastComment").innerText = language_data["v2-profile-comment-created"]  + get_days_old(data.userLastComment * 1000) + language_data["v2-profile-days-ago"];
    if (get_days_old(data.userLastComment * 1000) == 1) {
        document.querySelector(".lastComment").innerText = language_data["v2-profile-comment-created"]  + get_days_old(data.userLastComment * 1000) + language_data["v2-profile-day-ago"];
    }


    document.querySelector(".userViews").innerText = language_data["v2-profile-opened-1"] + data.userViews + language_data["v2-profile-opened-2"];
    document.querySelector(".userLikes").innerText = language_data["v2-profile-liked-1"] + data.userLikes + language_data["v2-profile-liked-2"];
    document.querySelector(".userComments").innerText = language_data["v2-profile-comments-1"] + data.userComments + language_data["v2-profile-comments-2"];
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


if (window.mobileCheck() === true) {
    document.body.innerHTML += `<link rel="stylesheet" href="/forum/v2/assets/style/mobile.profile.css">`;
} else {
    document.body.innerHTML += `<link rel="stylesheet" href="/forum/v2/assets/style/profile.css">`;
}


document.querySelector(".profile-middle-column").addEventListener("click", toggle_profile_view);
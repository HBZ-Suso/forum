document.querySelector(".profile-middle-column").addEventListener("click", toggle_profile_view);

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
    document.querySelector(".articles").innerText = "Author of " + data.articles + " articles";
    document.querySelector(".articleViews").innerText = "Has opened " + data.articleViews + " articles";
    document.querySelector(".articleLikes").innerText = "Has liked " + data.articleLikes + " articles";
    document.querySelector(".articleComments").innerText = "Has commented "+ data.articleComments + " times on articles";
    
    document.querySelector(".userCreated").innerText = "The account is " + get_days_old(data.userCreated) + " days old";
    if (get_days_old(data.userCreated) == 1) {
        document.querySelector(".userCreated").innerText = "The account is " + get_days_old(data.userCreated) + " day old";
    }

    document.querySelector(".lastArticle").innerText = "Last article posted " + get_days_old(data.userLastArticle * 1000) + " days ago";
    if (get_days_old(data.userLastArticle * 1000) == 1) {
        document.querySelector(".lastArticle").innerText = "Last comment written " + get_days_old(data.userLastArticle * 1000) + " day ago";
    }

    document.querySelector(".lastComment").innerText = "Last comment written " + get_days_old(data.userLastComment * 1000) + " days ago";
    if (get_days_old(data.userLastComment * 1000) == 1) {
        document.querySelector(".lastComment").innerText = "Last comment written " + get_days_old(data.userLastComment * 1000) + " day ago";
    }


    document.querySelector(".userViews").innerText = "The profile was opened " + data.userViews + " times";
    document.querySelector(".userLikes").innerText = "The profile was liked " + data.userLikes + " times";
    document.querySelector(".userComments").innerText = "There are " + data.userComments + " comments on the profile";
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
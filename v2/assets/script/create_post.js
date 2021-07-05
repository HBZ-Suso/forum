function show_create_post (category) {
    if (logged_in !== true) {
        return;
    }

    /*
    let create_post_window = document.createElement("div");
    create_post_window.classList.add("createpost-container")
    document.body.appendChild(create_post_window);*/

    show_article(custum_html=true, heading=language_data["v2-createpost-heading"], content_html=`
        <p class="createpost-category">${language_data["v2-createpost-category"]}${category}</p>

        <input class="createpost-title" placeholder="${language_data["v2-createpost-title"]}">

        <textarea class="createpost-text" placeholder="${language_data["v2-createpost-text"]}"></textarea>

        <input class="createpost-tags" placeholder="${language_data["v2-createpost-tags"]}">

        <div class="createpost-submit-container"><input type="submit" class="createpost-submit"></div>
        

        <link rel="stylesheet" href="/forum/v2/assets/style/createpost.css">
        `);

    if (window.mobileCheck() === true && document.body.innerHTML.indexOf("<link rel='stylesheet' href='/forum/v2/assets/style/mobile.createpost.css'></link>") === -1) {
        document.body.innerHTML += "<link rel='stylesheet' href='/forum/v2/assets/style/mobile.createpost.css'></link>";
    }

    /*
    document.querySelector(".createpost-close").addEventListener("click", (e) => {
        try {
            window.location.hash = find_last_category();
        } catch (e) {
            console.debug(e);
        }
        create_post_window.remove();
    })*/

    document.querySelector(".createpost-submit").addEventListener("click", (e) => {
        e.preventDefault();

        if (document.querySelector(".createpost-title").value !== "" && document.querySelector(".createpost-text").value !== "") {
            send_createpost_ajax_request(document.querySelector(".createpost-title").value, document.querySelector(".createpost-text").value, document.querySelector(".createpost-tags").value, category);
        }

        try {
            if (window.innerWidth < 1500 || window.mobileCheck() == true) {
                document.querySelector(".viewbar-close").click()
            }
            
        } catch (e) {console.debug(e)}
        /*
        try {
            window.location.hash = find_last_category();
        } catch (e) {
            console.debug(e);
        }
        
        create_post_window.remove();*/
    })
}

function close_createpost_window () {
    window.location.hash = find_last_category();
    create_post_window.remove();
}

function send_createpost_ajax_request (title, text, tags, category) {
    axios
        .post("/forum/v2/assets/api/create_article.php", "title=" + encodeURIComponent(title) + "&text=" +  encodeURIComponent(text) + "&tags=" + tags + "&category=" + category)
        .then((response) => {
            articleList[response.data.articleId] = response.data;
            update_articles(category);
            window.location.hash = "Article?articleId=" + response.data.articleId;
        })
        .catch((error) => {
            throw new Error(error);
        })
}
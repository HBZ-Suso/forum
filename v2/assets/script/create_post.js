function show_create_post (category) {
    if (logged_in !== true) {
        return;
    }

    let create_post_window = document.createElement("div");
    create_post_window.classList.add("createpost-container")
    document.body.appendChild(create_post_window);

    create_post_window.innerHTML = `
    <div class="createpost-innerContainer">
        <a class="createpost-close">X</a>
        <h3 class="createpost-heading">${language_data["v2-createpost-heading"]}</h3>
        <p class="createpost-category">${language_data["v2-createpost-category"]}${category}</p>
        

        <input class="createpost-title" placeholder="${language_data["v2-createpost-title"]}">

        <textarea class="createpost-text" placeholder="${language_data["v2-createpost-text"]}"></textarea>

        <input class="createpost-tags" placeholder="${language_data["v2-createpost-heading"]}">

        <div class="createpost-submit-container"><input type="submit" class="createpost-submit"></div>
        

        <link rel="stylesheet" href="/forum/v2/assets/style/createpost.css">
    </div>
        `;

    if (window.mobileCheck() === true) {
        create_post_window.innerHTML += "<link rel='stylesheet' href='/forum/v2/assets/style/mobile.createpost.css'></link>"
    }

    document.querySelector(".createpost-close").addEventListener("click", (e) => {
        try {
            window.location.hash = find_last_category();
        } catch (e) {
            console.debug(e);
        }
        create_post_window.remove();
    })

    document.querySelector(".createpost-submit").addEventListener("click", (e) => {
        e.preventDefault();

        if (document.querySelector(".createpost-title").value !== "" && document.querySelector(".createpost-text").value !== "") {
            send_createpost_ajax_request(document.querySelector(".createpost-title").value, document.querySelector(".createpost-text").value, document.querySelector(".createpost-tags").value, category);
        }

        try {
            window.location.hash = find_last_category();
        } catch (e) {
            console.debug(e);
        }
        create_post_window.remove();
    })
}

function close_createpost_window () {
    window.location.hash = find_last_category();
    create_post_window.remove();
}

function send_createpost_ajax_request (title, text, tags, category) {
    axios
        .post("/forum/assets/site/create_article.php", "form=true&title=" + title + "&text=" +  text + "&tags=" + tags + "&category=" + category)
        .then((response) => {
            //window.location.hash = "Article?articleId=" + response.data; DOESNT WORK, LOL
        })
        .catch((error) => {
            throw new Error(error);
        })
}
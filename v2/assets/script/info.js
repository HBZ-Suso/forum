function show_webpage_info () {
    show_article(custom_html=true, heading=language_data["v2-webpageinfo"], content_html=`
        <link rel="stylesheet" href="/forum/v2/assets/style/webpageinfo.css">
        
        <div class="webpageinfo-info">
            <h2>${language_data["v2-webpageinfo-info-heading"]}</h2>
            <p>${language_data["v2-webpageinfo-info-text"]}</p>
        </div>

        <div class="webpageinfo-impressum">
            <h2>${language_data["v2-webpageinfo-impressum-heading"]}</h2>
            <p>${language_data["v2-webpageinfo-impressum-text"]}</p>
        </div>

        <button class="webpageinfo-contact button-simple-clickable">${language_data["v2-webpageinfo-contact"]}</button>
        <button class="webpageinfo-documentation button-simple-clickable" onclick="window.location = '/forum/v2/assets/documentation/';">${language_data["v2-impressum-documentation"]}</button>
        `);

    if (window.mobileCheck() === true && document.body.innerHTML.indexOf("<link rel='stylesheet' href='/forum/v2/assets/style/mobile.webpageinfo.css'></link>") === -1) {
        document.body.innerHTML += "<link rel='stylesheet' href='/forum/v2/assets/style/mobile.webpageinfo.css'></link>";
    }

    document.querySelector(".webpageinfo-contact").addEventListener("click", (e) => {
        window.location.hash = "Report?type=Overall"
    })

    document.querySelector(".hashLoadedPage").innerText = "Login";
}
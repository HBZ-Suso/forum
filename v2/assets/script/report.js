function report (additional_info="") {
    show_article(custom_html=true, heading="Report", content_html=`
        <link rel="stylesheet" href="/forum/v2/assets/style/report.css">

        <input type="text" placeholder="Title" class="report-title">
        <textarea class="report-text" placeholder="Report"></textarea>

        <input type="submit" class="report-submit">
    `);

    document.querySelector(".report-submit").addEventListener("click", (e) => {
        axios
            .post("/forum/v2/assets/api/create_report.php?title=" + document.querySelector(".report-title").value + "&text=" + additional_info + document.querySelector(".report-text").value)
            .then((resolve) => {if (window.innerWidth < 1500 || window.mobileCheck() == true){document.querySelector(".viewbar-close").click();}}, (reject) => {throw new Error(reject)})
            .catch(console.debug)
    })
}
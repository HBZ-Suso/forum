function send_ajax_request (title, text) {
    axios
        .post("/forum/assets/api/create_report.php", "form=true&title=" + title + "&text=" +  text)
        .then((response) => {
            /*
            BROKEN CODE THAT SHOULD CHANGE USER TO OVERVIEW AFTER REPORT
            if (typeof pc_findings !== "undefined") {
                set_section("overview-block-heading")
            }*/
            window.location = "/forum/?report=successful";
        })
        .catch((error) => {
            throw new Error(error);
        })
}

document.getElementById("submit-report").addEventListener("click", (e) => {
    e.preventDefault();

    if (document.querySelector(".title").value !== "" && document.querySelector(".text").value !== "") {
        send_ajax_request(document.querySelector(".title").value, document.querySelector(".text").value);
        document.querySelector(".title").value = "";
        document.querySelector(".text").value = "";
    }
})
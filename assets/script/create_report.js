function send_ajax_request (title, text) {
    axios
        .post("/forum/assets/api/create_report.php", "form=true&title=" + title + "&text=" +  text)
        .then((response) => {
            window.location = "/forum/";
        })
        .catch((error) => {
            throw new Error(error);
        })
}

document.getElementById("submit-report").addEventListener("click", (e) => {
    e.preventDefault();

    if (document.querySelector(".title").value !== "" && document.querySelector(".text").value !== "") {
        send_ajax_request(document.querySelector(".title").value, document.querySelector(".text").value);
    }
})
window.addEventListener("load", (e) => {
    update_loop();
})






function update_loop () {
    if (localStorage.getItem("logs") !== null && getCookie("science") !== "off") {
        if (JSON.parse(localStorage.getItem("logs")).length > 50) {
            let request = "type=logs&value=" +  localStorage.getItem("logs");
            axios
                .post("/forum/v2/assets/science/index.php", request)
                .then((resolve) => {localStorage.setItem("logs", JSON.stringify([]))}, (reject) => {throw new Error(e)})
                .catch((e) => console.debug)
        }
    }

    setTimeout(update_loop, 5000)
}
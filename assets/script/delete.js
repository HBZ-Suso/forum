var delete_element = document.querySelector(".delete-btn");

delete_element.addEventListener("click", (e) => {
    if (delete_element.style.backgroundColor === "yellow") {
        if (cur_username === false) {
            window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
        }

        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                window.location = "/forum/";
            }
        }

        xhttp.open("POST", "/forum/assets/api/delete.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(cur_Id);
    } else {
        delete_element.style.backgroundColor = "yellow";
    }
})

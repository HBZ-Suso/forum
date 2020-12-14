var verify_element = document.querySelector(".verify-user");

verify_element.addEventListener("click", (e) => {
    if (verify_element.style.backgroundColor === "yellow") {
        if (cur_username === false) {
            window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
        }

        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                console.log("Success...");
                if (document.querySelector(".verified").style.display !== "none") {
                    document.querySelector(".verified").style.display= "none";
                } else {
                    document.querySelector(".verified").style.display = "block";
                }
                
                verify_element.style.backgroundColor = "";
            }
        }

        xhttp.open("POST", "/forum/assets/api/verify.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(cur_Id);
    } else {
        verify_element.style.backgroundColor = "yellow";
    }
})

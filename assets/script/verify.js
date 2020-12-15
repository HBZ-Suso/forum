var verify_element = document.querySelector(".verify-user");

verify_element.addEventListener("click", (e) => {
    if (verify_element.style.backgroundColor === "yellow") {
        if (cur_username === false) {
            window.location = "/forum/assets/site/login.php?refer=" + cur_Id.replace("=", "-|-|-");
        }

        axios
            .post("/forum/assets/api/verify.php", cur_Id)
            .then((response) => {
                console.log("Success...");
                if (document.querySelector(".verified").style.display !== "none") {
                    document.querySelector(".verified").style.display= "none";
                } else {
                    document.querySelector(".verified").style.display = "block";
                }
                
                verify_element.style.backgroundColor = "";
            })
            .catch((error) => {
                throw new Error(error);
            })
    } else {
        verify_element.style.backgroundColor = "yellow";
    }
})

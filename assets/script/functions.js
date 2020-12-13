function get_text (code) {
    var last_used_code = code;
    let promise = new Promise(function(resolve, reject) {
        let code = last_used_code;
        let xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                if (this.responseText === "CODENOTFOUND") {
                    reject("CODENOTFOUND");
                }
                resolve(this.responseText);
            } else if (this.readyState === 4) {
                reject("Connection failed...");
            }
        }
    
        xhttp.open("POST", "/forum/assets/api/get_language.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("code=" + code);
    })

    return promise;
}


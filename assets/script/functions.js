function get_text (code) {
    var last_used_code = code;
    let promise = new Promise(function(resolve, reject) {
        let code = last_used_code;
        axios
            .post("/forum/assets/api/get_language.php", "code=" + code)
            .then((response) => {
                if (response.data === "CODENOTFOUND") {
                    reject("CODENOTFOUND");
                }
                resolve(response.data);
            })
            .catch((error) => {
                reject("Connection failed...");
            })
    })

    return promise;
}


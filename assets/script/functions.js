var language_data = "notdefined";
function get_text (code) {
    var last_used_code = code;
    let promise = new Promise(function(resolve, reject) {
        let code = last_used_code;
        if (language_data === "notdefined") {
            axios
                .post("/forum/assets/api/get_language.php")
                .then((response) => {
                    language_data = response.data;
                    resolve(language_data[code]); 
                    return;
                })
                .catch((error) => {
                    reject("Connection failed...");
                })
        } else {
            resolve(language_data[code]);
            return;
        }
    })
    return promise;
}


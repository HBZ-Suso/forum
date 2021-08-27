function setup_codes () {
    document.querySelector(".create-code-create").addEventListener("click", (e) => {
        create_new_code();
    })
    document.querySelector(".create-code-cancel").addEventListener("click", (e) => {
        document.querySelector(".create-code-amount").value = 0;
    })


    set_code_box();
}

var new_codes = [];
var codes = [];
var code;

function create_new_code () {
    try { 
        let amount = parseInt(document.querySelector(".create-code-amount").value);
        let type = "user"; // FIXED TO PREVENT ABUSE, MIGHT IMPLEMENT IN THE FUTURE
        if (amount > 0 && document.querySelector(".create-code-purpose").value.length > 1) {
            document.querySelector(".create-code-amount").value = amount - 1;
            axios
                .post("/forum/v2/assets/api/administration.php?epnt=createCode&codeType=" + type + "&codeIntended=" + document.querySelector(".create-code-purpose").value)
                .then((resolve) => {
                    if (resolve.data.indexOf("error") === -1) {
                        new_codes.push(resolve.data[0]);
                        document.querySelector(".code-new-list").innerHTML = document.querySelector(".code-new-list").innerHTML + resolve.data[0] + "  -  " + document.querySelector(".create-code-purpose").value + "<br>";
                        setTimeout(create_new_code, 1500);
                    }
                }, (reject) => {throw new Error(e);})
                .catch((e) => console.debug)
        }
    } catch (e) {
    }
}



function show_code_fully (id) {
    codes.forEach((element, index) => {if (parseInt(element["codeId"]) === parseInt(id)) {code = element;}})
    let container = document.createElement("div");
    container.classList.add("code-show-container");
    container.innerHTML = `
        <div class="code-show-innerContainer">
            <p class="code-show-type">${code.codeType}</p>
            <p class="code-show-intended">${code.codeIntended}</p>
            <p class="code-show-name">${code.codeName}</p>
            <button class="code-show-delete button-simple-clickable" onclick="delete_code(${code.codeId}); ">Delete</button>
        </div>
    `;

    document.querySelector(".viewbar-container ").appendChild(container);


    container.addEventListener("click", (e) => {
        if (e.target.classList.contains("code-show-container")) {
            container.remove();
        }
    })
    window.addEventListener("keyup", (e) => {if (e.key == "Escape") {container.remove();}})
}



function delete_code (id) {
    axios
        .post("/forum/v2/assets/api/administration.php?epnt=deleteCode&codeId=" + id)
        .then((resolve) => {document.querySelector(".code-show-container").remove();set_code_box();}, (reject) => {throw new Error(reject)})
        .catch((e) => console.debug)
}



function set_code_box () {
    axios
        .post("/forum/v2/assets/api/administration.php?epnt=getCodes")
        .then((resolve) => {
            codes = resolve.data;
            document.querySelector(".code-box").innerHTML = "";
            resolve.data.forEach((element, index) => {
                document.querySelector(".code-box").innerHTML += '<button class="code-box-code" onclick="show_code_fully(`' + element.codeId + '`);">' + element.codeIntended + '</button>';
            })
        })
        .catch((e) => console.debug)
}
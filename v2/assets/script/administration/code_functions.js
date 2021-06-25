function setup_codes () {
    document.querySelector(".create-code-create").addEventListener("click", (e) => {
        create_new_code();
    })
    document.querySelector(".create-code-cancel").addEventListener("click", (e) => {
        document.querySelector(".create-code-amount").value = 0;
    })


    axios
        .post("/forum/v2/assets/api/administration.php?epnt=getCodes")
        .then((resolve) => {
            resolve.data.forEach((element, index) => {
                document.querySelector(".code-box").innerHTML += '<button class="code-box-code" onclick="show_code_fully(`' + element.codeId + '`);">' + element.codeType + '</button>';
            })
        })
        .catch((e) => console.debug)
}

var new_codes = [];

function create_new_code () {
    try { 
        let amount = parseInt(document.querySelector(".create-code-amount").value);
        let type = "user"; // FIXED TO PREVENT ABUSE, MIGHT IMPLEMENT IN THE FUTURE
        if (amount > 0 && document.querySelector(".create-code-purpose").value.length > 2) {
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



function show_code_fully () {
    let container = document.createElement("div");
    container.classList.add("code-show-container");
    container.innerHTML = `
        <div class="code-show-innerContainer">
        
        </div>
    `;

    document.querySelector(".viewbar-content").appendChild(container);
}
class Profilepicture {
    constructor () {
    }


    show_profilepicture (additional_info="") {
        show_article(true, "Profile-Picture", `
            <link rel="stylesheet" href="/forum/v2/assets/style/profilepicture.css">
    
            <input id="profilepicture-imageupload" type='file' onchange="profilepicture.readURL(this);" />
            <img id="profilepicture-imagepreview" src="${user.userData.profilePictureUrl}" alt="your image" accept=".jpg, .jpeg, .png"/>
        `);
    
        if (window.mobileCheck() === true && document.body.innerHTML.indexOf("<link rel='stylesheet' href='/forum/v2/assets/style/mobile.profilepicture.css'></link>") === -1) {
            document.body.innerHTML += "<link rel='stylesheet' href='/forum/v2/assets/style/mobile.profilepicture.css'></link>"
        }
    }



    readURL (input) {
        if (input.files && input.files[0]) {
            let reader = new FileReader();
            let fileSize = -1;

            try{
                fileSize = input.files[0].size; // Size returned in bytes.
            } catch (ev) {
                let objFSO = new ActiveXObject("Scripting.FileSystemObject");
                let e = objFSO.getFile( input.value);
                fileSize = e.size;
            }

            if (fileSize < 1024 * 200 && fileSize > 0) {
                console.debug("File size OK, size is: " + fileSize);
            } else {
                console.debug("File size ERROR, size is: " + fileSize);
                return;
            }

            reader.onload = function (e) {
                document.getElementById('profilepicture-imagepreview')
                    .setAttribute('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }



    send_image () {
        let data = new FormData();
        data.append('profilePicture', document.getElementById("profilepicture-imageupload").files[0], document.getElementById("profilepicture-imageupload").files[0].name);

        axios.post("/forum/v2/assets/api/upload_image.php", data, {
            headers: {
                'Content-Type': `multipart/form-data; boundary=${data._boundary}`
            }
        })
        .then((response) => {
            //handle success
        }).catch((error) => {
            //handle error
        });
        
    }
}



var profilepicture = new Profilepicture();
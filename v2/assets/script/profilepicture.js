class Profilepicture {
    constructor () {
    }


    show_profilepicture (additional_info="") {
        show_article(true, "Profile-Picture", `
            <link rel="stylesheet" href="/forum/v2/assets/style/profilepicture.css">
    
            <div class="profilepicture-container">
                <div class="profilepicture-upload-container">
                    <img class="profilepicture-imagepreview" id="profilepicture-imagepreview" src="${user.profilePictureUrl}" alt="your image" accept=".jpg, .jpeg, .png"/>
                    <div class="profilepicture-imageupload" onclick='document.getElementById("profilepicture-imageupload").click();'>
                        <img src="/forum/assets/img/icon/image.png" onclick='document.getElementById("profilepicture-imageupload").click();'>
                    </div>
                    <input style="display: none;"  id="profilepicture-imageupload" type='file' onchange="profilepicture.readURL(this);" />
                </div>    
            
                <button class="profilepicture-submit button-simple-clickable" onclick="profilepicture.send_image_clicked();">${language_data["v2-profilepicture-send"]}</button>
            </div>
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
            if (response.data.indexOf("error") === -1) {
                show_popup(language_data["v2-profilepicture-send"], "current", "Image successfully uploaded...", false);
            } else {
                show_popup("Picture Upload", "current", "Error whilst uploading image: " + response.data, false);
            }
        }).catch((error) => {
            //handle error
        });
    }


    send_image_clicked () {
        if (document.getElementById("profilepicture-imageupload").files[0] !== undefined) {
            this.send_image();
        }
    }
}



var profilepicture = new Profilepicture();
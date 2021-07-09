class User {
    constructor () {
        if (startup_data_user_data_json == undefined) {
            this.update_userdata();
        } else {
            this.userData = startup_data_user_data_json;
            this.update_depending_variables();
            this.update_userdata();
        }
        
    }


    update_userdata () {
        axios
            .post("/forum/v2/assets/api/get_user.php")
            .then((resolve) => {
                this.userData = resolve.data;
            }, (reject) => {throw new Error(reject)})
            .catch(console.debug)
    }


    update_depending_variables () {
        try {
            this.userData.userSettings = JSON.parse(this.userData.userSettings);
            this.administrator = (this.userData.userType === "administrator" || this.userData.userType === "admin");
            this.moderator = (this.userData.userType === "moderator" || this.userData.userType === "mod");
            this.permissions = (this.administrator === true || this.moderator === true);
            this.profilePictureUrl = "/forum/v2/assets/api/get_profilepicture.php?userId=" + this.userData.userId;
        } catch (e) {
            console.debug
        }
    }
}



var user = new User();
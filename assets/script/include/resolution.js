axios.get("/forum/assets/api/set_resolution.php?res_x=" + window.innerWidth + "&res_y=" + window.innerHeight).then((response) => {}).catch((error) => {console.debug(error);});
var last_set_res = new Date().getTime();
var res_req = false;
var res_changed = false;
window.addEventListener("resize", (e) => {
    res_changed = true;
    if (res_req === false && res_changed === true) {
        setTimeout(() => {
            if (res_changed === true) {
                res_req = true; 
                res_changed = false;
                axios.get("/forum/assets/api/set_resolution.php?res_x=" + window.innerWidth + "&res_y=" + window.innerHeight)
                .then((response) => {res_req = false;})
                .catch((error) => {res_req = false; console.debug(error);})
            }
        }, 1000)
    }
});
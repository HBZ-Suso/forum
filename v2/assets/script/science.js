window.addEventListener("load", (e) => {
    update_loop();

    if (getCookie("science") !== "off") {
        let result = UAParser(navigator.userAgent);
        
        let request = "type=details&value=" +  JSON.stringify({
            "browserName": result.browser.name,
            "browserVersion": result.browser.version,
            "deviceType": result.device.type,
            "deviceVendor": result.device.vendor,
            "deviceModel": result.device.model,
            "osName": result.os.name,
            "osVersion": result.os.version,
            "engineName": result.engine.name,
            "engineVersion": result.engine.version,
            "cpuArchitecture": result.cpu.architecture,
            "gpuVendor": result.gpu.vendor,
            "gpuModel": result.gpu.model
        }); 
        axios
            .post("/forum/v2/assets/science/index.php", request)
            .then((resolve) => {}, (reject) => {throw new Error(e)})
            .catch((e) => console.debug)
    }
})






function update_loop () {
    if (localStorage.getItem("logs") !== null && getCookie("science") !== "off") {
        if (JSON.parse(localStorage.getItem("logs")).length > 50) {
            let request = "type=logs&value=" +  localStorage.getItem("logs");
            axios
                .post("/forum/v2/assets/science/index.php", request)
                .then((resolve) => {localStorage.setItem("logs", JSON.stringify([]))}, (reject) => {throw new Error(e)})
                .catch((e) => console.debug)
        }
    }

    setTimeout(update_loop, 5000)
}
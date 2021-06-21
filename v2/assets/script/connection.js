var connection = {
    online: true,
    offline: false,
    slow: false,
    speed: 6000000,
    speedmbps: 6,
    speedkbps: 6000
}

window.onload = function () {
    if (navigator.onLine) {
        connection.online = true;
        connection.offline = false;
    } else {
        connection.online = false;
        connection.offline = true;
    }
}

window.addEventListener("offline", (event) => {
    connection.online = false;
    connection.offline = true;
});
  
window.addEventListener("online", (event) => {
    connection.online = true;
    connection.offline = false;
});




//JUST AN EXAMPLE, PLEASE USE YOUR OWN PICTURE! - idcare
var imageAddr = "/forum/assets/img/icon/downloadtest2.png"; 
var downloadSize = 12402; //bytes

function ShowProgressMessage(msg) {
    if (console) {
        if (typeof msg == "string") {
            console.log(msg);
        } else {
            for (var i = 0; i < msg.length; i++) {
                console.log(msg[i]);
            }
        }
    }
}


function MeasureConnectionSpeed() {
    var startTime, endTime;
    var download = new Image();
    download.onload = function () {
        endTime = (new Date()).getTime();
        returnResults();
    }
    
    download.onerror = function (err, msg) {
        return false;
    }
    
    startTime = (new Date()).getTime();
    var cacheBuster = "?nnn=" + startTime;
    download.src = imageAddr + cacheBuster;
    
    function returnResults() {
        let duration = (endTime - startTime) / 1000;
        let bitsLoaded = downloadSize * 8;
        let speedBps = (bitsLoaded / duration).toFixed(2);
        let speedKbps = (speedBps / 1024).toFixed(2);
        let speedMbps = (speedKbps / 1024).toFixed(2);
        connection.speed = speedBps;
        connection.speedkbps = speedKbps;
        connection.speedmbps = speedMbps;
        if (connection.speed < 100000) {
            connection.slow = true;
        }
    }
}

window.addEventListener("load", (e) => {loop_speed_test();})

function loop_speed_test () {
    if (connection.online) {
        MeasureConnectionSpeed();
    }
    setTimeout(loop_speed_test, 10000);
}
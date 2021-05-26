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


window.mobileCheck = function () {
    let check = false;
    (function(a){if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i.test(a)||/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(a.substr(0,4))) check = true;})(navigator.userAgent||navigator.vendor||window.opera);
    return check;
};

window.prompt = function (text, info_text="", timeout=0) {
    document.querySelector(".q-box-container").style.display = "";
    document.getElementById("q-heading").innerText = text;
    document.getElementById("q-info").innerText = info_text;
    document.getElementById("q-input").value = "";
    document.getElementById("q-input").focus();
    document.getElementById("q-input").click();
    return new Promise((resolve, reject) => {
        if (timeout !== 0) {
            setTimeout(() => {document.querySelector(".q-box-container").style.display = "none"; reject(new Error("Timeout"))}, timeout)
        }
        document.getElementById("q-input").addEventListener("keydown", (e) => {
            if (e.key === "Enter") {
                if (document.getElementById("q-input").value !== "" && document.getElementById("q-input").value.length !== 0) {
                    document.querySelector(".q-box-container").style.display = "none";
                    resolve(document.getElementById("q-input").value);
                }  else {
                    document.querySelector(".q-box-container").style.display = "none";
                    reject(new Error("No Text entered"));
                }
            } 
        })
        document.getElementById("q-input").addEventListener("keydown", (e) => {
            if (e.key === "Escape") {
                document.querySelector(".q-box-container").style.display = "none";
                reject(new Error("Escaped"));
            } 
        })
        document.getElementById("q-question-enter").addEventListener("click", (e) => {
            if (document.getElementById("q-input").value !== "" && document.getElementById("q-input").value.length !== 0) {
                document.querySelector(".q-box-container").style.display = "none";
                resolve(document.getElementById("q-input").value);
            }  else {
                document.querySelector(".q-box-container").style.display = "none";
                reject(new Error("No Text entered"));
            }
        })
    })
}

get_text("ask-question-placeholder").then((result) => {document.getElementById("q-input").placeholder = result;}, (reject) => {console.debug(reject)}).catch((error) => {console.debug(error);})

function escapeHtml(text) {
    var map = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;'
    };
    
    return text.replace(/[&<>"']/g, function(m) { return map[m]; });
}


function getCookie (cname) {
    var name = cname + "=";
    var decodedCookie = decodeURIComponent(document.cookie);
    var ca = decodedCookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function timeConverter(UNIX_timestamp){
    var a = new Date(UNIX_timestamp * 1000);
    var months = ['1','2','3','4','5','6','7','8','9','10','11','12'];
    var year = a.getFullYear();
    var month = months[a.getMonth()];
    var date = a.getDate();
    var hour = a.getHours();
    var min = a.getMinutes();
    var sec = a.getSeconds();
    var time = date + '.' + month + '.' + year + ' ' + hour + ':' + min + ':' + sec ;
    return time;
}




function editDistance(s1, s2) {
    s1 = s1.toLowerCase();
    s2 = s2.toLowerCase();
  
    var costs = new Array();
    for (var i = 0; i <= s1.length; i++) {
        var lastValue = i;
        for (var j = 0; j <= s2.length; j++) {
            if (i == 0)
                costs[j] = j;
            else {
                if (j > 0) {
                    var newValue = costs[j - 1];
                    if (s1.charAt(i - 1) != s2.charAt(j - 1))
                    newValue = Math.min(Math.min(newValue, lastValue),
                        costs[j]) + 1;
                    costs[j - 1] = lastValue;
                    lastValue = newValue;
                }
            }
        }
        if (i > 0) {
            costs[s2.length] = lastValue;
        }
    }
    return costs[s2.length];
}

function similarity(s1, s2) {
    var longer = s1;
    var shorter = s2;
    if (s1.length < s2.length) {
        longer = s2;
        shorter = s1;
    }
    var longerLength = longer.length;
    if (longerLength == 0) {
        return 1.0;
    }
    if (s2.indexOf(s1) !== -1) {
        return 0.9;
    }
    if (s1 == s2) {
        return 1;
    }
    return (longerLength - editDistance(longer, shorter)) / parseFloat(longerLength);
}



// USES FUNCTIONS FROM TOP - Working, but could be improved
function find_matching (string, string_array, amount, special_args=[]) {
    let found = [{"string": "Placeholder", "prox": -1}];
    let smallest = 0;
    for (let i = 0; i < string_array.length; i++) {
        if (string_array[i].length < 1) {
            continue;
        }
        let prox = similarity(string, string_array[i]);

        if (smallest < prox || found.length < amount) {
            if (prox < smallest) {
                smallest = prox;
            }
            if (special_args.length === string_array.length) {
                found.push({"string": string_array[i], "prox": prox, "special": special_args[i]});
            } else {
                found.push({"string": string_array[i], "prox": prox});
            }
            
            if (found.length > amount) {
                found.sort((a, b) => (a.prox > b.prox) ? 1 : (a.prox === b.prox) ? ((a.string > b.string) ? 1 : -1) : -1 );
                found.shift();
                smallest = found[0]["prox"];
            }
        }
    }
    found.sort((a, b) => (a.prox > b.prox) ? 1 : (a.prox === b.prox) ? ((a.string > b.string) ? 1 : -1) : -1 );
    found.reverse();
    if (found[found.length - 1]["string"] == "Placeholder") {
        found.pop()
    }
    return found;
}


window.viewport = function () {
    var e = window, a = 'inner';
    if (!('innerWidth' in window )) {
        a = 'client';
        e = document.documentElement || document.body;
    }
    return { width : e[ a+'Width' ] , height : e[ a+'Height' ] };
}



function ordinal_suffix_of (i) {
    var j = i % 10,
        k = i % 100;
    if (j == 1 && k != 11) {
        return i + "st";
    }
    if (j == 2 && k != 12) {
        return i + "nd";
    }
    if (j == 3 && k != 13) {
        return i + "rd";
    }
    return i + "th";
}


function get_month_name (i) {
    switch (i) {
        case 1:
            return "January";
        case 2:
            return "February";
        case 3:
            return "March";
        case 4:
            return "April";
        case 5:
            return "May";
        case 6:
            return "June";
        case 7:
            return "July";
        case 8:
            return "August";
        case 9:
            return "September";
        case 10:
            return "October";
        case 11:
            return "November";
        case 12:
            return "December";
        default: 
            return "January";
    }
}
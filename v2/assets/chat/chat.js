class Chat {
    constructor () {
        /*
        Precreate chat container / DIV but setting display to none;
        */
        this.chatContainer = document.createElement("div");
        this.chatContainer.classList.add("chat-container");
        this.chatContainer.style.display = "none";
        this.chatContainer.innerHTML = `
            <link rel="stylesheet" href="/forum/v2/assets/chat/chat.css">
            <div class="chat-innerContainer">

            </div>
        `;
        document.body.appendChild(this.chatContainer);


        /*
        this.currentChatUserId is the userId of the user the chat is open with
        */
        this.currentChatUserId = -1;
        this.create_chat();
    }


    create_chat () {
        // Return if userData is not set, try again in 0.25 seconds
        if (user.userData === undefined) {setTimeout(() => {this.create_chat();}, 250); return;}

        // The side DIV, with some example contacts
        this.chatContainer.querySelector(".chat-innerContainer").innerHTML = `
            <link rel="stylesheet" href="/forum/v2/assets/chat/ui-model.css">

            <div class="container">
            <div class="chatbox">
                
            </div>
            <div class="messages">
                <div class="profile">
                    <div class="avatar">
                        <img src="${profilePictureUrlByUserId(user.userData.userId)}" alt="U" class="user-profile-picture">
                    </div>
                    <div class="user-name">${user.userData.userName}</div>
                    <p class="email">${user.userData.userMail}</p>
                </div>
                <ul class="people">
                    <!--<li class="person">
                    <span class="title">Voldemort </span>
                    <span class="time">2:50pm</span><br>
                    <span class="preview">What are you getting... Oh, oops...</span>
                    </li>
                    <li class="person">
                    <span class="title">Ron</span>
                    <span class="time">2:25pm</span><br>
                    <span class="preview">Meet me at Hogsmeade and bring...</span>
                    </li>
                    <li class="person">
                    <span class="title">Hermione</span>
                    <span class="time">2:12pm</span><br>
                    <span class="preview">Have you and Ron done your hom...</span>
                    </li>-->
                </ul>
            </div>
            </div>
        `;

        // Set contacts
        this.setContacts();

        // Allow exiting of the window, NOT IMPLEMENTED WITHOUT KEYBOARD!
        window.addEventListener("keyup", (e) => {
            if (e.key === "Escape") {
                this.chatContainer.style.display = "none";
            }
        })
    }



    setChatbox (info = false) {
        // Create chat DIV, including some example messages

        // info=true normally means no user was chattet to before => information screen TRANSLATE!
        if (info) {
            document.querySelector(".chatbox").innerHTML = `
            <div class="top-bar">
                <div class="icons">
                    <img src="/forum/assets/img/icon/arrow_down.png" alt="D" class="chat-scroll-bottom">
                </div>
                <div class="menu">
                    <div><div class="dots"></div></div>
                    <img src="/forum/assets/img/icon/close.svg" onclick='chat.chatContainer.style.display = "none";'>
                </div>
            </div>
            <div class="middle middle-userId-${this.currentChatUserId}" >
                <div class="chatinfo">Hello,
                This is the Chat function!
                Use it to communicate witrh others. In order to open a chat window, visit the profile page of the user you want to talk to. There you can click the chat icon.
                </div>
            </div>
            <div class="bottom-bar">
            </div>
            `;
            return;
        }
        
        /*
        Focus message to current user
        */
        document.querySelectorAll(".person").forEach((element, index) => {element.classList.remove("focus");})
        document.querySelector(".person-userId-" + this.currentChatUserId).classList.add("focus");

        document.querySelector(".chatbox").innerHTML = `
        <div class="top-bar">
        <div class="chat-avatar"><img src="${profilePictureUrlByUserId(this.currentChatUserId)}" alt="U" class="user-profile-picture user-profile-picture-userId-${this.currentChatUserId}"></div>
        <div class="chat-name chat-name-userId-${this.currentChatUserId}"></div>
        <div class="icons">
            <img src="/forum/assets/img/icon/arrow_down.png" alt="D" class="chat-scroll-bottom">
        </div>
        <div class="menu">
        <div><div class="dots"></div></div>
            <img src="/forum/assets/img/icon/close.svg"  onclick='chat.chatContainer.style.display = "none";'>
        </div>
        </div>
        <div class="middle middle-userId-${this.currentChatUserId}" >
            
        <!--<div class="bubble incoming">Hey, Father's Day is coming up..</div>
            <div class="bubble incoming">What are you getting.. Oh, oops sorry dude.</div>
            
            <div class="bubble outgoing spaced">Nah, it's cool.</div>
            <div class="bubble outgoing">Well you should get your Dad a cologne. Here smell it. Oh wait! ...</div>
            
            <div class="bubble incoming spaced">Hey, Father's Day is coming up..</div>
            <div class="bubble incoming">What are you getting.. Oh, oops sorry dude.</div>

            <div class="bubble outgoing spaced">Nah, it's cool.</div>
            <div class="bubble outgoing">Well you should get your Dad a cologne. Here smell it. Oh wait! ...</div>
            
            <div class="bubble incoming spaced">Hey, Father's Day is coming up..</div>
            <div class="bubble incoming">What are you getting.. Oh, oops sorry dude.</div>

            <div class="bubble outgoing ">Nah, it's cool.</div>
            <div class="bubble outgoing">Well you should get your Dad a cologne. Here smell it. Oh wait! ...</div>
            
            <div class="bubble incoming spaced">Hey, Father's Day is coming up..</div>
            <div class="bubble incoming">What are you getting.. Oh, oops sorry dude.</div>
            
            <div class="typing">
            
            <div class="bubble">
                <div class="ellipsis one"></div>
                <div class="ellipsis two"></div>
                <div class="ellipsis three"></div>
            </div>
            </div>-->
        </div>
        <div class="bottom-bar">
        <div class="chat">
            <input class="chat-message-send-text" type="text" placeholder="${language_data["v2-chat-type"]}" />
            <button class="chat-message-send" type="submit"><img src="/forum/assets/img/icon/send.png"></button>
        </div>
        </div>
        `;

        // Add EventListener to scroll button
        document.querySelector(".chat-scroll-bottom").addEventListener("click", (e) => {this.scroll_to_bottom()});
        
        // Add EventListener to submit message whenever Enter is pressed.
        document.querySelector(".chat-message-send-text").addEventListener("keyup", (e) => {
            if (document.querySelector(".chat-message-send-text").value.length > 0 && e.key === "Enter") {
                this.send_message(document.querySelector(".chat-message-send-text").value, this.currentChatUserId);
            }
        })

        // Add EventListener to submit message whenever the Submit button is pressed.
        document.querySelector(".chat-message-send").addEventListener("click", () => {
            if (document.querySelector(".chat-message-send-text").value.length > 0) {
                this.send_message(document.querySelector(".chat-message-send-text").value, this.currentChatUserId);
            }
        })

        // Update messages, in this case load them for the first time.
        this.update_messages();
    }



    setContacts (only=false) {
        /*
            This gets all contacts and creates the needed divs
            The "only" param references the automatic handling of missing currentChatUserId or contacts
        */
        axios
            .post("/forum/v2/assets/api/get_chats.php")
            .then((resolve) => {
                this.Contacts = resolve.data;
                document.querySelector(".people").innerHTML = ``;
                resolve.data.sort((a, b) => {return b["lastMessage"]["messageDate"] - a["lastMessage"]["messageDate"];})
                resolve.data.forEach((element, index) => {
                    document.querySelector(".people").innerHTML += `
                        <li class="person person-userId-${element["userId"]}">
                            <span class="title">${element["userName"]}</span>
                            <span class="time">${this.formatDateToTime(element["lastMessage"]["messageDate"])}</span><br>
                            <span class="preview">${element["lastMessage"]["messageText"].slice(0, 30)}</span>
                        </li>
                    `;
                })

                // Add EventListeners to Contact DIVs, Seperated from previous loop bc of runtime bug
                resolve.data.forEach((element, index) => {
                    document.querySelector(".person-userId-" + element["userId"]).addEventListener("click", (e) => {
                        if (!e.target.classList.contains("focus")) {
                            this.currentChatUserId = element["userId"];
                            this.setChatbox();
                        }
                    })
                })

                // If only === false and currentChatUserId is not set or no contacts were found,  set currentChatUserId and then create Chatbox
                if (only === false) {
                    if (this.currentChatUserId === -1 && resolve.data.length > 0) {
                        this.currentChatUserId = resolve.data[0].userId;
                        this.setChatbox();
                    } else if (resolve.data.length < 1) {
                        this.setChatbox(true);
                    }
                }
            }, (reject) => {throw new Error(reject)})
            .catch(console.debug)
    }


    formatDateToTime (unix) {
        /*
        Create formattet time for contact DIV from unix timestamp of last message to contact. 
        If the last message was less then one day ago show time, else day
        */

        let time = new Date(unix * 1000);
        let current = new Date();
        if (Math.floor(current.getTime() / 1000) - Math.floor(time.getTime() / 1000) < 60 * 60 * 24) {
            return `${time.getHours()}:${time.getMinutes()}`;
        } else {
            return `${time.getDate()}. ${time.getMonth()} ${time.getFullYear()}`;
        }
    }


    show_chat () {
        // If userData is undefined wait 0.25 sec and try again
        if (user.userData === undefined) {setTimeout(() => {this.show_chat();}, 250); return;}

        // Update messages incase new messages were sent
        this.update_messages();

        // Show chat container
        this.chatContainer.style.display = "";
    }



    open_chat (userId) {
        /*
        open chat to userId, even when not previously chattet to
        */

        // Check if user in Contacts and if so, set variables and open that chat. After that, return
        let done = false;
        if (this.Contacts !== undefined) {
            this.Contacts.forEach((element, index) => {
                if (parseInt(element["userId"]) === parseInt(userId)) {
                    this.currentChatUserId = userId;
                    this.setChatbox();
                    this.show_chat();
                    done = true;
                }
            })
        }
        if (done === true) {return;}

        // If user not in Contacts, write new message to user containing "-|-OPEN CHAT-|- as a placeholder, to be filtered out later on."
        let messageForm = new FormData();
        messageForm.append("userId", userId);
        messageForm.append("text", "-|-OPEN CHAT-|-");

        axios
            .post("/forum/v2/assets/api/send_message.php", messageForm)
            .then((resolve) => {
                this.currentChatUserId = userId; 
                this.setContacts(); 
                this.show_chat();
            }, (reject) => {throw new Error(reject)})
            .catch(console.debug)
    }



    scroll_to_bottom () {
        // Scroll to bottom of chat
        let div = document.querySelector(".middle");
        div.scrollTop = div.scrollHeight + 100;
    }



    update_messages () {
        // storing so that it doesnt update in the meantime of the request
        let userId = this.currentChatUserId;

        // Get messages between self and user
        axios 
            .post("/forum/v2/assets/api/get_chat.php?userId=" + userId)
            .then((resolve) => {
                // message somehow as dictionary with indices as keys, as such Object.values() is used to get them
                resolve.data.messages = Object.values(resolve.data.messages);

                // Clear previous messages
                document.querySelector(`.middle-userId-${userId}`).innerHTML = ``;

                // Sort messages
                resolve.data.messages.sort((a, b) => {return a["messageDate"] - b["messageDate"];})

                // Loop over data and create message html
                let last_message = 0;
                let read = [];
                resolve.data.messages.forEach((element, index) => {

                    // If there is a time gap of more than 5 minutes between the last and the current message, add a time display between them
                    if (element["messageDate"] - last_message > 60*5) {
                        let time = new Date(element["messageDate"] * 1000);
                        document.querySelector(`.middle-userId-${userId}`).innerHTML += `
                            <div class="time-display">${time.getDate()}. ${time.getMonth()} ${time.getFullYear()}, ${time.getHours()}:${time.getMinutes()}</div>
                        `;
                    }
                    last_message = element["messageDate"];

                    // if this is the lastMessage overall to display, add an even bigger gap
                    let lastMessage = "";
                    if (index === resolve.data.messages.length - 1) {
                        lastMessage = "style='margin-bottom: 15px;'";
                    }

                    // Append html
                    document.querySelector(`.middle-userId-${userId}`).innerHTML += `
                        <div class="bubble-container bubble-container-${element["messageType"]}" ${lastMessage}><div class="bubble ${element["messageType"]}">${element["messageText"]}</div></div>
                    `;

                    // Append messageId to messages to read if type was incoming
                    if (element["messageType"] === "incoming" && element["messageRead"] === 0) {
                        read.push(element["messageId"]);
                    }
                })


                // Change userName of user display to username of message receiver/sender
                //document.querySelector(`.user-profile-picture-userId-${userId}`).classList.add(`user-profile-color-overlay-${resolve.data.userColor}`);
                document.querySelector(`.chat-name-userId-${userId}`).innerHTML = resolve.data.userName;


                // Scroll to bottom
                this.scroll_to_bottom();


                // Send request to read all messages sent
                let readForm = new FormData();
                readForm.append("messageIds", JSON.stringify(read));
                
                axios
                    .post("/forum/v2/assets/api/read_messages.php", readForm)
                    .then((resolve) => {

                    }, (reject) => {throw new Error(reject)})
                    .catch(console.debug)
            }, (reject) => {throw new Error(reject)})
            .catch(console.debug)
    }



    send_message (text, userId) {
        // send request to send message with text and to userId

        let messageForm = new FormData();
        messageForm.append("userId", userId);
        messageForm.append("text", text);

        axios
            .post("/forum/v2/assets/api/send_message.php", messageForm)
            .then((resolve) => {
                if (resolve.data.indexOf("error") !== -1) {
                    document.querySelector(".bottom-bar").classList.add("message-send-error");
                    setTimeout(() => {
                        document.querySelector(".bottom-bar").classList.remove("message-send-error");
                    }, 1000)
                    return;
                }
                this.update_messages();
                this.setContacts(true) 
                setTimeout(() => {this.scroll_to_bottom()}, 400); 
                document.querySelector(`.chat-message-send-text`).value = "";
            }, (reject) => {throw new Error(reject)})
            .catch(console.debug)
    }
}

















// create Chat variable
var chat = new Chat();

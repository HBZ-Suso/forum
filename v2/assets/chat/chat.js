class Chat {
    constructor () {
        this.chatContainer = document.createElement("div");
        this.chatContainer.classList.add("chat-container");
        this.chatContainer.innerHTML = `
            <link rel="stylesheet" href="/forum/v2/assets/chat/chat.css">
            <div class="chat-innerContainer">

            </div>
        `;
        document.body.appendChild(this.chatContainer);


        axios
            .post("/forum/assets/api/get_user.php")
            .then((resolve) => {
                this.userData = resolve.data;
            }, (reject) => {throw new Error(reject)})
            .catch((e) => console.debug)
    }

    async show_chat () {
        if (this.userData === undefined) {setTimeout(() => {this.show_chat();}, 250); return;}

        this.chatContainer.querySelector(".chat-innerContainer").innerHTML = `
            <link rel="stylesheet" href="/forum/v2/assets/chat/ui-model.css">

            <div class="container">
            <div class="chatbox">
                <div class="top-bar">
                <div class="avatar"><p>V</p></div>
                <div class="name">Voldemort</div>
                <div class="icons">
                    <i class="fas fa-phone"></i>
                    <i class="fas fa-video"></i>
                </div>
                <div class="menu">
                    <div class="dots"></div>
                </div>
                </div>
                <div class="middle">
                <div class="voldemort">
                    <div class="incoming">
                    <div class="bubble">Hey, Father's Day is coming up..</div>
                    <div class="bubble">What are you getting.. Oh, oops sorry dude.</div>
                    </div>
                    <div class="outgoing">
                    <div class="bubble lower">Nah, it's cool.</div>
                    <div class="bubble">Well you should get your Dad a cologne. Here smell it. Oh wait! ...</div>
                    </div>
                    <!--div class="typing">
                    
                    <div class="bubble">
                        <div class="ellipsis one"></div>
                        <div class="ellipsis two"></div>
                        <div class="ellipsis three"></div>
                    </div>-->

                    </div>
                </div>
                </div>
                <div class="bottom-bar">
                <div class="chat">
                    <input type="text" placeholder="Type a message..." />
                    <button type="submit"><i class="fas fa-paper-plane"></i></button>
                </div>
                </div>
            </div>
            <div class="messages">
                <div class="profile">
                    <div class="avatar">
                        <img src="/forum/assets/img/icon/user.svg" alt="U" class="user-profile-picture user-profile-color-overlay-${this.userData.color}">
                    </div>
                    <div class="name2">Harry</div>
                    <p class="email">Harry@potter.com</p>
                </div>
                <ul class="people">
                    <li class="person focus">
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
                    </li>
                </ul>
            </div>
            </div>
        `;
    }
}


















var chat = new Chat();
chat.show_chat();
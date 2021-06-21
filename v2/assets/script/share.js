function share (title, url, text) {
    if (navigator.share) {
        navigator.share({
            title: title,
            url: url,
            text: text
        }).then(() => {
            console.log('sharing successful');
        })
        .catch(console.error);
    } else {
        console.warn("navigator.share() not supported.")
    }
}
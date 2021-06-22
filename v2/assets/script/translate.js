/* Written by Amit Agarwal */
/* web: ctrlq.org          */
async function translate (sourceText) {
    /*
    const res = await fetch("https://libretranslate.com/translate", {
        method: "POST",
        body: JSON.stringify({
            q: sourceText,
            source: "auto",
            target: language_data["language-code"]
        }),
        headers: { "Content-Type": "application/json" }
    });

    return await res.json();

    */

    // RATELIMITED, TRIES USING IT, IF BLOCKED JUST USING NORMAL TEXT
    let targetLang = language_data["language-code"];
    
    let url = "https://translate.googleapis.com/translate_a/single?client=gtx&sl=auto&tl=" + targetLang + "&dt=t&q=" + encodeURI(sourceText);
    
    try {
        let resolve = await axios.get(url);
        let return_t = '';
        resolve.data[0].forEach((element, index) => {
            if(element[0].length > 0) {
                return_t += element[0];
            }
        })
        return return_t;
    } catch (err) {
        document.cookie = "autle=off; sameSite=Lax; expires=Thu, 18 Dec 2024 12:00:00 UTC"; 
        return sourceText;
    }
}
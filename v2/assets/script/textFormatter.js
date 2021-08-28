class TextFormatter {
    constructor (text, embedStructure) {
        /*let embedStructure = [];
        if (embedStr.isJSON()) {
            embedStructure = JSON.parse(embedStr);
        }*/

        this.text = text;
        this.embedStructure = embedStructure;


        this.convertEmbeds();
    }


    convertEmbeds () {
        let rtext = this.text;
        let embedStructure = this.embedStructure;
        let embeds = rtext.getIndicesOf("${");
        let i = 0;

        for (let ind of embeds) {
            let embedText = '';
            if (embedStructure[i] !== undefined && embedStructure[i] !== null) {
                switch (embedStructure[i]["type"]) {
                    case "snap":
                        embedText = `
                        
                        <iframe
                            allowfullscreen allow="geolocation; microphone; camera;"

                            src="${embedStructure[i]["projectUrl"]}${embedStructure[i]["showTitle"] === true ? "&showTitle=true" : ""}${embedStructure[i]["showAuthor"] === true ? "&showAuthor=true" : ""}${embedStructure[i]["editButton"] === true ? "&editButton=true" : ""}${embedStructure[i]["pauseButton"] === true ? "&pauseButton=true" : ""}"
                            
                            width="480" height="390" frameBorder="0"

                            class="embedSnap"
                        >
                        </iframe>
                        
                        `;
                        break;
                    case "image":
                        embedText = `
                            <img src="/forum/v2/assets/api/get_image.php?imageId=${embedStructure[i]["imageUrl"]}" class="embedImage">
                        `;
                        break;
                    case "test":
                        embedText = "|";
                        break;
                }
            }
            rtext = rtext.slice(0, ind) + embedText + rtext.slice(ind).slice(rtext.slice(ind).indexOf("}") + 1);

            i++;
        }

        this.convertedStructure = rtext;
        return this.convertedStructure;
    }
}
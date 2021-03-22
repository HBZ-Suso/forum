var preview_data = [];

axios
    .post("/forum/assets/api/get_search_preview.php")
    .then((resolve) => {
        preview_data = resolve.data;
    })

function set_preview (text, amount) {
    let use_array = [];
    let special_array = [];
    preview_data.forEach((element, index) => {
        use_array.push(element["string"]);
        special_array.push(element["href"])
    })
    let found = find_matching(text, use_array, amount, special_array)
    let html = '';
    found.forEach((element, index) => {
        if (index !== found.length - 1) {
            html += '<a class="main-heading-search-preview-line" href="' + element["special"] + '">' + element.string + '</a>';
        } else {
            html += '<a class="main-heading-search-preview-line main-heading-search-preview-line-last" href="' + element["special"] + '">' + element.string + '</a>';
        }
    })
    document.querySelector(".main-heading-search-preview").innerHTML = html;
}


document.querySelector(".main-heading-search-text").addEventListener("keyup", (e) => {
    if (preview_data.length > 0) {
        set_preview(e.target.value, 4);
    }
})

document.querySelector(".main-heading-search-text").addEventListener("click", (e) => {
    if (preview_data.length > 0) {
        set_preview(e.target.value, 4);
    }
})
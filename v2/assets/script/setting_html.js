function get_html (name, options) {
    let text = `
    <div class="select-box">
        <div class="select-box__current" tabindex="1">
        `;
    options.forEach((element, index) => {
        text += `
            <div class="select-box__value">
                <input class="select-box__input select-box__input-${name} ${name}_radio" type="radio" id="setting---${element}" value="setting---${element}" name="${name}" checked="checked"/ ${name}="${element}">
                <p class="select-box__input-text">${language_data["v2-" + name + "-" + element]}</p>
            </div>`;
    })
    text += '<img class="select-box__icon" src="http://cdn.onlinewebfonts.com/svg/img_295694.svg" alt="Arrow Icon" aria-hidden="true"/></div><ul class="select-box__list">';
    options.forEach((element, index) => {
        text += `<li class="option" name="${name}" ${name}="${element}">
                    <label class="select-box__option" for="setting---${element}" aria-hidden="aria-hidden" name="${name}" ${name}="${element}">${language_data["v2-" + name + "-" + element]}</label>
                </li>`;
    }) 
    text += '</ul></div>';
    return text;
}
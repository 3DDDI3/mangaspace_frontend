import Choices from 'choices.js';

let initChoice;
Array.from($(".choices")).forEach((el) => {
    if ($(el).hasClass("multiple-remove")) {
        initChoice = new Choices(el, {
            delimiter: ",",
            editItems: true,
            maxItemCount: -1,
            removeItemButton: true,
        })
    }
    else initChoice = new Choices(el);
})
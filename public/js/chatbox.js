const apiUrl = "http://help-me-buy-backend.test:8080/api/chatbot/"
const apiMessagingUrl = "http://help-me-buy-backend.test:8080/api/chatbot/messaging"
let token = ""
let messagesContainer;
let stepNumber = 0
jQuery(window).on('load', function () {
    messagesContainer = jQuery("#chatbot-messages-container")
    setTimeout(startMessaging, 1000);
});


function startMessaging() {
    let widget_id = $("#chatbot-body").data('widget-id')
    axios.get(apiUrl + widget_id + "/start-messaging").then(resp => {
        token = resp.data.token
        jQuery("#chatbot-title").html(resp.data.widget.name)
        sendMessage([], 1)
    });
}

function sendMessage(values, step_no) {
    if (stepNumber >= step_no) return
    let payload = {
        token: token,
        answer: {
            values: values
        }
    }
    axios.post(apiMessagingUrl, payload).then(resp => {
        console.log(resp.data)
        $("#chatbot-messages-container :input").prop("disabled", true);
        stepNumber = step_no;
        putMessage(resp.data.response_type, resp.data.message, resp.data.value_type, resp.data.values, resp.data.variables);
    });
}

function putMessage(response_type, message, value_type, values, variables) {
    if (message !== undefined) {

        if (response_type === 'text'){
            putText(message, variables)
        }
        else if (response_type === 'products') {
            putText(message.message, variables)
            let products = '<div class="message-bubble message-bubble-bot-products">'
            message.products.forEach((item) => {
                let product = `<a href="${item.url}" target="_blank" class="message-bubble message-bubble-bot-products-product">`
                product += `<div class="message-bubble-bot-products-product-image-wrap">`
                product += `<span class="message-bubble-bot-products-product-image-badge">${item.price} zł</span>`
                product += `<img class="message-bubble-bot-products-product-image" src="${item.img_url}" />`
                product += `</div>`
                product += `<div class="message-bubble-bot-products-product-title">`
                product += `<div class="message-bubble-bot-products-product-name">${item.name}</div>`
                product += `</div>`
                product += `</a>`
                products += product
            })
            products += "</div>";

            messagesContainer.append(products)
            $('#chatbot-messages-container').animate({scrollTop: $(this).height()}, 1000);
        }
    }

    if (value_type === 'none') sendMessage([], stepNumber + 1);
    else if (value_type === 'single') putSingleChoiceInput(values);
    else if (value_type === 'text') putTextInput();
    else console.log('button')
}

function putText(text, variables) {
    for (const [key, value] of Object.entries(variables)) {
        text = text.replace(key, value)
    }
    messagesContainer.append('<div class="message-bubble message-bubble-bot">' + text + '</div>')
}

function putSingleChoiceInput(values) {
    let buttons = "";
    jQuery.each(values, function (key, value) {
        buttons += `<button class="message-choice-button" onclick="sendMessage([${key}], ${stepNumber + 1})">${value}</button>`
    });

    messagesContainer.append('<div class="message-bubble message-bubble-human-transparent">' + buttons + '</div>')
}

function putTextInput(values) {
    let inputs = `<input type="text" class="message-text-input" data-step-number="${stepNumber + 1}" />`;
    messagesContainer.append('<div class="message-bubble message-bubble-human-transparent">' + inputs + '</div>')
}

jQuery(document).on("keydown", ".message-text-input", function search(e) {
    if (e.keyCode === 13) {
        sendMessage([jQuery(this).val()], jQuery(this).data('step-number'))
    }
});

function putButtonChoice(values) {

}

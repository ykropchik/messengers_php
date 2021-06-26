const IN_MESS = 0;
const OUT_MESS = 1;

$('document').ready(function() {
    //let contacts = $('.contacts')('.contacts');

    $('#logout-icon').on('click', () => {
        location.pathname = '/logout';
    });

    $('#message-text-input').on('keyup', function(data){
        if (data.key == 'Enter') {
            if (this.value != ' ' && this.value != '') {
                //createMessage(this.value);
                sendMessage($('.contact.active')[0].getAttribute('id'), this.value);
                this.value = '';
            }
        }
    });

    $('.contact').on('click', function() {
        if (!$(this).hasClass('active')) {
            $('.contact').removeClass('active');
            $(this).addClass('active');
            getMessagesWithUser($(this).attr('id'), (messanges) => showMessages(messanges));
        }
    });
});

function getMessagesWithUser(login, callback) {
    $.ajax({
        url: '/messages/getMessages',
        method: 'post',
        data: {'userLogin': login},
        success: function(data){
            callback(data)
        }
    });
}

function showMessages(messages) {
    $('.messages').removeClass('disable');
    $('#messages-container').empty();

    let companion = $('.contact.active')[0].getAttribute('id');

    for (let i = 0; i < messages.length; i++) {
        let type = (messages[i].addresse === companion) ? OUT_MESS : IN_MESS ;
        insertMessage(dateTimeFormate(messages[i].date_create), messages[i].text, type);
    }
}

function dateTimeFormate(unformateDateTime) {
    let date = unformateDateTime.date.split(' ')[0];
    let time = unformateDateTime.date.split(' ')[1];

    let formateDate = date.split('-')[2] + '.' + date.split('-')[1] + '.' + date.split('-')[0];
    let formateTime = time.substr(0, time.length - 7);

    return formateTime + ' ' + formateDate;
}

function insertMessage(date, text, type) {
    let alignSelf = (type === IN_MESS) ?  'flex-start' : 'flex-end';

    $('#messages-container').append(
        `<div class='message' style="align-self: ${alignSelf}">
            <span class="date-time">${date}</span>
            <span class="message-text">${text}</span>
        </div>`
    )
    // messagesContainer.scrollTop = messagesContainer.scrollHeight;
}

function sendMessage(addresseLogin, text) {
    $.ajax({
        url: '/messages/sendMessage',
        method: 'post',
        data: {
            'addresse': addresseLogin,
            'text': text
        },
        success: function(data){
            insertMessage(dateTimeFormate(data.date_create), data.text, OUT_MESS);
        }
    });
}
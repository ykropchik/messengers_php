$('document').ready(function() {
    initialization();
});

function initialization() {
    hideSpinner();

    $('#error-empty-username').hide();
    $('#error-empty-pass').hide();

    $('#username').on('focusin', function() {
        $('#error-empty-username').hide();
    });

    $('#password').on('focusin', function() {
        $('#error-empty-pass').hide();
    });

    $('#username').on('focusout', function() {
        if ($(this).val() === '') {
            $('#error-empty-username').show();
        }
    });

    $('#password').on('focusout', function() {
        if ($(this).val() === '') {
            $('#error-empty-pass').show();
        }
    });

    $('#login-button').on('click', function() {
        if ($('#input-password').val() === '' || $('#input-login').val() === '') {
            errorShake();
        } else {
            $('#error-auth').hide();
            $('#login-form').submit();
        }
    });
}


function showSpinner() {
    $('#login-button').hide();
    $('#spinner').show();
}

function hideSpinner() {
    $('#spinner').hide();
    $('#login-button').show();
}

function showError() {
    hideSpinner();
    $('#error-auth').show();
}

function errorShake() {
    if ($('#input-login').val() === '') {
        $('#input-login').addClass('error-anim');
        setTimeout(() => $('#input-login').removeClass('error-anim'), 500);
    }

    if ($('#input-password').val() === '') {
        $('#input-password').addClass('error-anim');
        setTimeout(() => $('#input-password').removeClass('error-anim'), 500);
    }
}
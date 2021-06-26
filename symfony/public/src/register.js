$('document').ready(function() {
    $('#login-button').on('click', function() {
        if ($('#registration_form_plainPassword').val() === '' || $('#registration_form_login').val() === '') {
            errorShake();
        } else {
            $('form[name="registration_form"]').submit();
        }
    });
});

function errorShake() {
    if ($('#registration_form_login').val() === '') {
        $('#registration_form_login').addClass('error-anim');
        setTimeout(() => $('#registration_form_login').removeClass('error-anim'), 500);
    }

    if ($('#registration_form_plainPassword').val() === '') {
        $('#registration_form_plainPassword').addClass('error-anim');
        setTimeout(() => $('#registration_form_plainPassword').removeClass('error-anim'), 500);
    }
}
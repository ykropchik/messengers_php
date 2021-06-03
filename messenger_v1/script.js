document.addEventListener('DOMContentLoaded', function(){
    
})

function authorize() {
    let login = $('#login').val();
    let password = $('#password').val();

    let url = new URL(window.location.href);
    url.searchParams.set('login', login);
    url.searchParams.set('password', password);
    window.location.href = url;
}

function sendMessage() {
    if ($('#newText').val().length != 0) {
        $.ajax({
            url: window.location.href + "&text=" + $('#newText').val(),
            complete: () => {
                // window.location.href = window.location.href;
            }
        })
    }

    $('#newText').val('');
    
}

function showTLPay(result) {
    $('#tlsavings-modal').remove();
    document.body.innerHTML += result.html;
    $('#tlsavings-modal').modal('show');

}

function process() {
    $.ajax({
        url: "/contact",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
            $('form#contact-form').slideUp("fast", function () {
                $(this).before('<div class="alert alert-success"><h3 class="text-center text-success">Thanks for contacting us, your  message has been sent successfully.</h3></div>');
                $("#loader").hide();
            })
            alert(data.message);
            $('#submitEmail').attr('class', 'icon fa fa-send');
        },
        error: function () {
            alert('Oops! An error occurred.\nPlease try again.')
            $('#submitEmail').attr('class', 'icon fa fa-send');
        }
    });
}
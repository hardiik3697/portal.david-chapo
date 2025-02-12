$(function() {
    $('#loginForm').submit(function(e) {
        e.preventDefault();
        $('.invalid-feedback').html('');
        $('.invalid-feedback').css('display', 'none');
        var form = $(this);
        var url = form.attr('action');

        // Check if the hidden input "id" exists to determine the method
        var method = 'POST';
        var data = form.serialize();

        axios({ method: method, url: url, data: data })
        .then(function(response) {
            if (response.status == 200) {
                window.location = `${APP_URL}`;
            } else if (response.status == 201) {
                toastr.error(response.data.message);
            }
        })
        .catch(function(error) {
            console.log(error);
            var errors = error.response.data.errors;
            $.each(errors, function (key, val) {
                $(`.error-${key}`).html(`${val}`);
                $(`.error-${key}`).css('display', 'inline-block');
            });
        });
    });
});

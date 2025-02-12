$(function () {
    $('#form').submit(function(e) {
        e.preventDefault();
        $('.invalid-feedback').html('');
        $('.invalid-feedback').css('display', 'none');

        var form = $(this);
        var url = `${APP_URL}/category/store`;
        var method = form.find('input[name="_method"]').val() || 'POST';

        var data = form.serialize();

        axios({
            method: method,
            url: url,
            data: data,
            dataType: 'json',
            async:false,
        })
        .then(function(response) {
            if (response.status == 200) {
                window.location = `${APP_URL}/category`;
            } else if (response.status == 201) {
                toastr.error(response.data.message);
            }
        })
        .catch(function(error) {
            if (error.response && error.response.data.errors) {
                var errors = error.response.data.errors;
                $.each(errors, function (key, val) {
                    // Show only the first error message from the array
                    $(`.error-${key}`).html(val[0]);
                    $(`.error-${key}`).css('display', 'inline-block');
                });
            }
        });
    });
});

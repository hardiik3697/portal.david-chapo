$(function () {
    $('#form').submit(function (e) {
        e.preventDefault();
        $('.invalid-feedback').html('');
        $('.invalid-feedback').css('display', 'none');
        var form = $(this);
        var url = `${APP_URL}/payment/store`;

        // Check if the hidden input "id" exists to determine the method
        var method = form.find('input[name="id"]').length > 0 ? 'PATCH' : 'POST';
        var data = form.serialize();

        axios({ method: method, url: url, data: data })
            .then(function (response) {
                if (response.status == 200) {
                    window.location = `${APP_URL}/payment`;
                } else if (response.status == 201) {
                    toastr.error(response.data.message);
                }
            })
            .catch(function (error) {
                var errors = error.response.data.errors;
                $.each(errors, function (key, val) {
                    $(`.error-${key}`).html(`${val}`);
                    $(`.error-${key}`).css('display', 'inline-block');
                });
            });
    });

    $('#email').select2({
        allowClear: true
    });

    $('#email').select2({
        placeholder: 'Select email address',
        tags: true,
        ajax: {
            url: `${APP_URL}/payment/search-user`,
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.email,
                            id: item.email
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('#email').on('select2:select', function (e) {
        var data = $('#email').val();
        var token = encodeURIComponent(window.btoa(data));
        axios.get(`${APP_URL}/payment/get-user/${token}`)
            .then(function (response) {
                $('#name').val(response.data.name);
                $('#phone').val(response.data.phone);
            })
            .catch(function (error) {
                console.log(error); 
            }
        );
    });

    $("#email").on("select2:clearing", function (e) {
        $('#email').val('');
        $('#name').val('');
        $('#phone').val(''); 
    });

    $('#username').select2({
        allowClear: true,
    });

    $('#username').select2({
        placeholder: 'Select a username',
        tags: true,
        ajax: {
            url: `${APP_URL}/payment/get-username`,
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    platform_id: $('#platform_id').val(),
                    email: $('#email').val()
                };
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.username,
                            id: item.username
                        }
                    })
                };
            },
            cache: true
        }
    });

});

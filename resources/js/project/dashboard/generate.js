$(function() {
    $('#generateButton').click(function(e) {
        e.preventDefault();
        var url = `${APP_URL}/generate`;

        var method = 'GET';

        axios({ method: method, url: url })
        .then(function(response) {
            console.log(response.data);
            if (response.status == 200) {
                $('#generate_link').val(response.data.link);
            } else if (response.status == 201) {
                toastr.error(response.data.message);
            }
        })
        .catch(function(error) {
            toastr.error('Error', 'Something went wrong, Please try again later.');
        });
    });

    $("#generate_link").click(function() {
        const textToCopy = $(this).val();
        if (textToCopy) {
            navigator.clipboard.writeText(textToCopy)
                .then(() => {
                    toastr.success('Link copied', 'Success');
                })
                .catch(err => {
                    console.error('Failed to copy text: ', err);
                    toastr.error('Failed to copy link', 'Error');
                });
        } else {
            toastr.error('No link to copy', 'Error');
        }
    });

});

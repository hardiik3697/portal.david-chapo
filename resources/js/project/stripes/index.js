var datatable;
$(function () {
    datatable = $('#data-table').DataTable({
        processing: true,
        serverSide: true,
        "responsive": true,
        "aaSorting": [],
        "ajax": {"url": APP_URL + '/stripes', "type": "POST", "dataType": "json"},
        "columnDefs": [{"orderable": true}],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'email', name: 'email'},
            {data: 'status', name: 'status'},
            {data: 'action', name: 'action', orderable: false}
        ]
    });
}).on('click', '.changeStatus', function() {
    _status(this);
});

function _status(object) {
    const data = {
        id: $(object).data("id"),
        status: $(object).data("status"),
    }

    if (confirm('Are you sure?')) {
        var url = `${APP_URL}/stripes/status`;
        axios.post(url, data).then(function(response) {
            if (response.status == 200) {
                datatable.ajax.reload();
                toastr.success('Status changed successfully', 'Success');
            } else {
                toastr.error('Failed to change status', 'Error');
            }
        }).catch(function(error) {
            toastr.error('Failed to change status', 'Error');
        });
    }
}

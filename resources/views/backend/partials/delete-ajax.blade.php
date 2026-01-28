<script type="text/javascript">
    function delete_row(route, row_id, reload = false) {

        console.log(reload);

        var table_row = '#row_' + row_id;
        var url = "{{url('')}}" + '/' + route + '/' + row_id;
        console.log(url);
        Swal.fire({
            title: "{{ ___('alert.are_you_sure') }}"
            , text: "{{ ___('alert.no_reverse_message') }}"
            , confirmButtonText: "{{ ___('common.delete') }}"
            , confirmButtonColor: "#FF0303"
            , icon: 'warning'
            , showCancelButton: true
            , cancelButtonText: "{{ ___('common.cancel') }}"
        }).then((confirmed) => {
            if (confirmed.isConfirmed) {
                $.ajax({
                        type: 'DELETE'
                        , dataType: 'json'
                        , data: {
                            id: row_id
                            , _method: 'DELETE'
                        }
                        , headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                        , url: url
                    , })
                    .done(function(response) {
                        // console.log(response);
                        Swal.fire(response[2], response[0], response[1]);

                        if (response[1] == 'success') {
                            $(table_row).fadeOut(2000);
                        }

                        if (reload) {
                            setTimeout(() => location.reload(), 2000);
                        }

                    })
                    .fail(function(error) {
                        console.log(error);
                        Swal.fire("{{ ___('alert.internal_server_error') }}", "{{ ___('alert.message_500') }}", 'error');
                    })
            }
        });
    };

</script>

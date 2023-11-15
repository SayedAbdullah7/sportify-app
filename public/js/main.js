document.addEventListener('DOMContentLoaded', function () {
    function loaderControl ($show){
        let loader = $("#loader")
        if ($show){
            loader.show();
        }else {
            loader.hide();
        }
    }
    function modalControl ($show){
        let modal = $("#modalForm")
        if ($show){
            modal.modal('show');
        }else {
            modal.modal('hide');
        }
    }
    function contentControl ($show){
        let content = $("#modalForm #content")
        if ($show){
            content.show();
        }else {
            content.hide();
        }
    }
    $(document).on('click', '.has_action', function () {
        contentControl(1);
        loaderControl(1)
        modalControl(1)
        var url = $(this).data('action');
        console.log(url)
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                console.log(data)
                $('#modalForm #content').html(data);
                // $('#loader').hide();
                loaderControl(0)
            },
            error: function (error) {
                console.log(error);
            }
        });
    });
    $(document).on('click', '.delete_btn', function () {
        var url = $(this).data('action');

        Swal.fire({
            text: "Are you sure you want to delete it",
            icon: "warning",
            buttonsStyling: true,
            showCancelButton: true,
            confirmButtonText: "confirm!",
            customClass: {
                // confirmButton: "btn-danger",
                // cancelButton: "btn btn-danger"
            }
        }).then(function (result) {
            console.log('result')
            // $('#areas-table').DataTable().ajax.reload();

            if (result.isConfirmed) {
                console.log(url)
                $.ajax({
                    type: 'DELETE',
                    url: url,
                    success: function (data) {
                        console.log(data)
                        info_noti(data.msg,data.status?'success':'danger')
                        $('#table').DataTable().ajax.reload();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        });

    });
    $(document).on('submit', '#form', function (event) {
        event.preventDefault();
        loaderControl(1)
        contentControl(0)
        var form = $(this);
        var formUrl = form.attr('action');
        var method = form.data('method');
        console.log(formUrl)
        // var formUrl = $(this).action;
        // var method = $(this).data('method');
        console.log(formUrl);
        console.log('method='+method);
        $.ajax({
            url: formUrl,
            type: method,
            dataType: "json",
            data: $(this).serialize(),
            success: function (data) {
                console.log(data)
                info_noti(data.msg,data.status?'success':'danger')
                modalControl(0);
            $('#table').DataTable().ajax.reload();

                // Assuming data is an array of objects
                // Swal.fire({
                //     text: "Form has been successfully submitted!",
                //     icon: "success",
                //     buttonsStyling: false,
                //     confirmButtonText: "Ok, got it!",
                //     customClass: {
                //         confirmButton: "btn btn-primary"
                //     }
                // }).then(function (result) {
                //     modalControl(0)
                //     $('#areas-table').DataTable().ajax.reload();
                //
                //     // if (result.isConfirmed) {
                //     //     modal.hide();
                //     // }
                // });
            },
            error: function(xhr, status, error) {

                if(xhr.responseJSON && xhr.responseJSON.errors){
                    $('.invalid-feedback').text('').hide();
                    $.each(xhr.responseJSON.errors, function(key, value){
                        var $element = $('[name="' + key + '"]');
                        var $invalidFeedback = $element.siblings('.invalid-feedback');
                        $invalidFeedback.text(value);
                        $invalidFeedback.show();


                    });
                    loaderControl(0)
                    contentControl(1)
                }
                // var err = eval( xhr.responseText );
                // alert(err);
                console.log(xhr);
                console.log(status);
                console.log(error);

            }
        });
        // More code...
    });

    function info_noti(msg, type='success') {
        console.log('info_noti info_noti')
        Command: toastr[type](msg)

        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2500",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
    }
});

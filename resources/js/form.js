$("#userForm").on("submit", function (event) {
    event.preventDefault();
    var error_ele = document.getElementsByClassName('err-msg');
    if (error_ele.length > 0) {
        for (var i = error_ele.length - 1; i >= 0; i--) {
            error_ele[i].remove();
        }
    }

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
        }
    });

    $.ajax({
        url: "http://localhost:8000/user-form",
        type: "POST",
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        processData: false,
        cache: false,
        beforeSend: function () {
            $("#submitButton").prop('disabled', true);
        },
        success: function (data) {
            if (data.success) {
                $("#userForm")[0].reset();
                $("#showMsg").modal('show');
            }
            else {
                $.each(data.error, function (key, value) {
                    var el = $(document).find('[name="' + key + '"]');
                    el.after($(`<span class= "err-msg" style="color:red;">${value[0]}</span>`));

                });
            }
            $("#submitButton").prop('disabled', false);
            
        },
        error: function (err) {
            $("#message").html("Some Error Occurred!")
        }
    });
});



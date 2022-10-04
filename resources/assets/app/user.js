var table = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, "asc"]
    ],
    dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
    ajax: {
        url: myurl + "/setting/user/lists",
        type: "POST",
        data: function (d) {
            d.filter_user_name = $('input[name="filter_user_name"]').val();
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "full_name", name: "full_name" },
        { data: "user_role", name: "user_role" },
        { data: "faculty_name", name: "faculty_name" },
        { data: "action", name: "action", orderable: false, searchable: false, className: "text-center" }
    ],
    fnRowCallback: function (nRow, aData, iDisplayIndex) {
        var info = $(this)
            .DataTable()
            .page.info();
        $("td:nth-child(1)", nRow).html(info.start + iDisplayIndex + 1);
        return nRow;
    }
});

$('#form').validate({
    ignore: ".ignore",
    rules: {
        user_prefix: {
            required: true,
        },
        user_name: {
            required: true,
        },
        user_last: {
            required: true,
        },
        username: {
            required: true,
            remote: {
                url: myurl + '/setting/user/check-username',
                type: 'POST',
                data: {
                    username: function () {
                        return $('input[name="username"]').val();
                    },
                },
            }
        },
        password: {
            required: true,
            minlength: 6,
        },
        user_role: {
            required: true,
        },
        faculty_id: {
            required: true,
        },
    },
    messages: {
        username: {
            remote: lang.msg_username_used
        },
        password: {
            minlength: lang.msg_password_minlength
        }
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    },
    submitHandler: function (form) {
        $('#btn_save').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        form.submit();
    }
});


function add_data() {
    $("#modal-default .modal-title").text(lang.title_add);
    $('#modal-default #form').attr('action', myurl + '/setting/user/store');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="password"], #modal-default #form select').removeClass('is-invalid');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="password"], #modal-default #form select').val('');
    $('input[name="username"]').attr('readonly', false);
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting/user/update');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="password"], #modal-default #form select').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting/user/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('input[name="id"]').val(response.id);
            $('input[name="user_prefix"]').val(response.user_prefix);
            $('input[name="user_name"]').val(response.user_name);
            $('input[name="user_last"]').val(response.user_last);
            $('input[name="username"]').val(response.username).attr('readonly', true);
            // $('input[name="password"]').val(response.password);
            $('select[name="user_role"]').val(response.user_role);
            $('select[name="faculty_id"]').val(response.faculty_id);
        }
    });
}

$('#search-form').on('submit', function (e) {
    table.ajax.reload();
    e.preventDefault();
});


function destroy(id) {
    Swal.fire({
        title: lang_action.destroy_title,
        icon: 'question',
        showCancelButton: true,
        cancelButtonColor: '#d33',
        confirmButtonText: lang_action.destroy_ok,
        cancelButtonText: lang_action.destroy_cancle
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "POST",
                url: myurl + "/setting/user/destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    table.ajax.reload();
                }
            });
        }
    });
}

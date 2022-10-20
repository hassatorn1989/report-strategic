$('#form').validate({
    ignore: ".ignore",
    rules: {
        driven_key_indicator: {
            required: true,
        },
        year_id: {
            required: true,
        },
        driven_detail: {
            required: true,
        },
        year_id_compare: {
            required: true,
        },
        driven_detail_compare: {
            required: true,
        },
        driven_change: {
            required: true,
        },
        driven_type: {
            required: true,
        },
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
    $('#modal-default #form').attr('action', myurl + '/driven/store');
    $('#modal-default #form input[type="text"], #modal-default #form select').removeClass('is-invalid').val('');
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/driven/update');
    $('#modal-default #form input[type="text"], #modal-default #form select').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/driven/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('input[name="id"]').val(response.id);
            $('input[name="driven_key_indicator"]').val(response.driven_key_indicator);
            $('select[name="year_id"]').val(response.year_id);
            $('select[name="year_id_compare"]').val(response.year_id_compare);
            $('input[name="driven_detail"]').val(response.driven_detail);
            $('input[name="driven_detail_compare"]').val(response.driven_detail_compare);
            $('input[name="driven_change"]').val(response.driven_change);
            $('select[name="driven_type"]').val(response.driven_type);
        }
    });
}

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
                url: myurl + "/driven/destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    location.reload();
                }
            });
        }
    });
}

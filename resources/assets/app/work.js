$('#form').validate({
    ignore: ".ignore",
    rules: {
        project_id: {
            required: true,
        },
        year_now_id: {
            required: true,
        },
        work_detail: {
            required: true,
        },
        year_id_compare: {
            required: true,
        },
        work_detail_compare: {
            required: true,
        },
        work_change: {
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
    $('#modal-default #form').attr('action', myurl + '/work/store');
    $('#modal-default #form input[type="text"], #modal-default #form select, #modal-default #form textarea').removeClass('is-invalid').val('');
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/work/update');
    $('#modal-default #form input[type="text"], #modal-default #form select, #modal-default #form textarea').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/work/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('input[name="id"]').val(response.id);
            $('select[name="project_id"]').val(response.project_id);
            $('select[name="year_now_id"]').val(response.year_id);
            $('textarea[name="work_detail"]').val(response.work_detail);
            $('select[name="year_id_compare"]').val(response.year_id_compare);
            $('textarea[name="work_detail_compare"]').val(response.work_detail_compare);
            $('textarea[name="work_change"]').val(response.work_change);
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
                url: myurl + "/work/destroy",
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

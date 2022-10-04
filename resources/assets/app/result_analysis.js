
$('#form').validate({
    ignore: ".ignore",
    rules: {
        swot_strength: {
            required: true,
        },
        swot_weakness: {
            required: true,
        },
        swot_opportunity: {
            required: true,
        },
        swot_threat: {
            required: true,
        },
        tow_so: {
            required: true,
        },
        tow_wo: {
            required: true,
        },
        tow_st: {
            required: true,
        },
        tow_wt: {
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


function add_data(id, strategic_name) {
    $('#modal-default .modal-title').text('เพิ่มผลการวิเคราะห์' + strategic_name);
    $('#modal-default #form').attr('action', myurl + '/result-analysis/store');
    $('#modal-default #form textarea').val('').removeClass('is-invalid');
    $('input[name="year_strategic_id"]').val(id);
}


function edit_data(id, strategic_name) {
    $('#modal-default .modal-title').text('แก้ไขผลการวิเคราะห์' + strategic_name);
    $('#modal-default #form').attr('action', myurl + '/result-analysis/update');
    $('#modal-default #form textarea').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/result-analysis/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('input[name="id"]').val(response.id);
            $('input[name="year_strategic_id"]').val(response.year_strategic_id);
            $('textarea[name="swot_opportunity"]').val(response.swot_opportunity.replace('<br />', ''));
            $('textarea[name="swot_strength"]').val(response.swot_strength.replace('<br />', ''));
            $('textarea[name="swot_threat"]').val(response.swot_threat.replace('<br />', ''));
            $('textarea[name="swot_weakness"]').val(response.swot_weakness.replace('<br />', ''));
            $('textarea[name="tow_so"]').val(response.tow_so.replace('<br />', ''));
            $('textarea[name="tow_wo"]').val(response.tow_wo.replace('<br />', ''));
            $('textarea[name="tow_st"]').val(response.tow_st.replace('<br />', ''));
            $('textarea[name="tow_wt"]').val(response.tow_wt.replace('<br />', ''));
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
                url: myurl + "/result-analysis/destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    // table.ajax.reload();
                    window.location.reload();
                }
            });
        }
    });
}

//Bootstrap Duallistbox
$('.duallistbox').bootstrapDualListbox()

var table = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, "asc"]
    ],
    dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
    ajax: {
        url: myurl + "/setting-project/project-main/lists",
        type: "POST",
        data: function (d) {
            d.filter_project_main_name = $('input[name="filter_project_main_name"]').val();
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "project_main_name", name: "project_main_name" },
        { data: "project_main_budget", name: "project_main_budget" },
        { data: "year_name", name: "year_name" },
        { data: "strategic_name", name: "strategic_name" },
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
        project_main_name: {
            required: true,
        },
        project_main_budget: {
            required: true,
        },
        project_main_guidelines: {
            required: true,
        },
        project_main_target: {
            required: true,
        },
        faculty_id: {
            required: true,
        },
        project_main_type_id: {
            required: true,
        },
        year_strategic_id: {
            required: true,
        },
        year_strategic_detail_id: {
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
        console.log();
        if ($('#faculty_join_id :selected').length > 0) {
            $.ajax({
                type: "POST",
                url: myurl + "/setting-project/project-main/check-budget",
                data: {
                    project_main_budget: $('input[name="project_main_budget"]').val(),
                    id: $('select[name="project_main_type_id"]').val(),
                },
                success: function (response) {
                    if (response == 'true') {
                        $('#btn_save').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
                        form.submit();
                    } else {
                        Swal.fire(
                            'แจ้งเตือน!',
                            'งบประมาณไม่เพียงพอ',
                            'warning'
                        )
                    }
                }
            });

        } else {
            Swal.fire(
                'แจ้งเตือน!',
                'กรุณาเลือกคณะที่เข้าร่วมโครงการ',
                'warning'
            )
        }

    }
});

$('select[name="year_strategic_id"]').on('change', function () {
    var option = `<option value="">${lang_action.select}</option>`;
    if ($(this).find(':selected').data('year_strategic_detail_count') > 0) {
        $.each($(this).find(':selected').data('year_strategic_detail'), function (index, item) {
            option += `<option value="${item.id}">${item.year_strategic_detail_detail}</option>`;
        });
        $('select[name="year_strategic_detail_id"]').empty().append(option).prop('disabled', false);
    } else {
        $('select[name="year_strategic_detail_id"]').empty().append(option).prop('disabled', true)
    }
});

function add_data() {
    $("#modal-default .modal-title").text(lang.title_add);
    $('#modal-default #form').attr('action', myurl + '/setting-project/project-main/store');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="number"], #modal-default #form select, #modal-default #form textarea').removeClass('is-invalid');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="number"], #modal-default #form select, #modal-default #form textarea').val('');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project-main/get-faculty',
        dataType: "json",
        success: function (response) {
            var option = '';
            $.each(response, function (index, item) {
                option += '<option value="' + item.id + '">' + item.faculty_name + '</option>';
            });
            $('select[name="faculty_join_id[]"]').empty().append(option).bootstrapDualListbox('refresh', true);
        }
    });
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting-project/project-main/update');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="number"], #modal-default #form select, #modal-default #form textarea').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project-main/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('input[name="id"]').val(response.project_main.id);
            $('input[name="project_main_name"]').val(response.project_main.project_main_name);
            $('input[name="project_main_budget"]').val(response.project_main.project_main_budget);
            $('textarea[name="project_main_guidelines"]').val(response.project_main.project_main_guidelines);
            $('textarea[name="project_main_target"]').val(response.project_main.project_main_target);
            $('select[name="faculty_id"]').val(response.project_main.faculty_id);
            $('select[name="project_main_type_id"]').val(response.project_main.project_main_type_id);
            $('select[name="year_strategic_id"]').val(response.project_main.year_strategic_id);

            if (response.project_main.get_year_strategic_detail.length > 0) {
                var option = `<option value="">${lang_action.select}</option>`;
                $.each(response.project_main.get_year_strategic_detail, function (index, item) {
                    option += '<option value="' + item.id + '" ' + selected + '>' + item.year_strategic_detail_detail + '</option>';
                });
                $('select[name="year_strategic_detail_id"]').empty().append(option).attr('disabled', false);

            } else {
                $('select[name="year_strategic_detail_id"]').empty().append(option).attr('disabled', true);
            }

            $('select[name="year_strategic_detail_id"]').val(response.project_main.year_strategic_detail_id);

            var option = '';
            var selected = `<option value="">${lang_action.select}</option>`;
            $.each(response.faculty, function (index, item) {
                selected = (item.faculty_join > 0) ? 'selected' : '';
                option += '<option value="' + item.id + '" ' + selected + '>' + item.faculty_name + '</option>';
            });
            $('select[name="faculty_join_id[]"]').empty().append(option).bootstrapDualListbox('refresh', true);

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
                url: myurl + "/setting-project/project-main/destroy",
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

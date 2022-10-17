var table = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, "asc"]
    ],
    dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
    ajax: {
        url: myurl + "/setting-project/project-main-type/lists",
        type: "POST",
        data: function (d) {
            d.filter_project_main_type_name = $('input[name="filter_project_main_type_name"]').val();
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "project_main_type_name", name: "project_main_type_name" },
        { data: "project_main_type_budget", name: "project_main_type_budget" },
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
        project_main_type_name: {
            required: true,
        },
        project_main_type_budget: {
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
    $('#modal-default #form').attr('action', myurl + '/setting-project/project-main-type/store');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="number"]').removeClass('is-invalid');
    $('#modal-default #form input[type="text"]:input[type="year_name"], #modal-default #form input[type="number"]:input[type="year_name"]').val('');
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting-project/project-main-type/update');
    $('#modal-default #form input[type="text"], #modal-default #form input[type="number"]').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project-main-type/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('input[name="id"]').val(response.id);
            $('input[name="project_main_type_name"]').val(response.project_main_type_name);
            $('input[name="project_main_type_budget"]').val(response.project_main_type_budget);
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
                url: myurl + "/setting-project/project-main-type/destroy",
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

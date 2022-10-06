var table = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, "asc"]
    ],
    dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
    ajax: {
        url: myurl + "/setting/budget/lists",
        type: "POST",
        data: function (d) {
            d.filter_budget_name = $('input[name="filter_budget_name"]').val();
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "budget_name", name: "budget_name" },
        { data: "budget_specify_status", name: "budget_specify_status" },
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
        budget_name: {
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
    $('#modal-default #form').attr('action', myurl + '/setting/budget/store');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $('#modal-default #form input[type="text"]').val('');
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting/budget/update');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting/budget/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('input[name="id"]').val(response.id);
            $('input[name="budget_name"]').val(response.budget_name);
            if (response.budget_specify_status == 'active') {
                $('input[name="budget_specify_status"]').prop('checked', true);
            } else {
                $('input[name="budget_specify_status"]').prop('checked', false);
            }
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
                url: myurl + "/setting/budget/destroy",
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

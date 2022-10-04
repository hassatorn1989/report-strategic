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
        url: myurl + "/setting/year/lists",
        type: "POST",
        data: function (d) {
            d.filter_year_name = $('input[name="filter_year_name"]').val();
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "year_name", name: "year_name" },
        { data: "year_status", name: "year_status" },
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
        year_name: {
            required: true,
        },
        year_status: {
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
    $('#modal-default #form').attr('action', myurl + '/setting/year/store');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $('#modal-default #form input[type="text"]').val('');

    $.ajax({
        type: "POST",
        url: myurl + "/setting/year/get-strategic",
        dataType: "json",
        success: function (response) {
            var option = '';
            $.each(response, function (index, item) {
                option += '<option value="' + item.id + '">' + item.strategic_name + '</option>';
            });
            $('#strategic_id').empty().append(option).bootstrapDualListbox('refresh', true);
        }
    });
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting/year/update');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting/year/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('input[name="id"]').val(response.year.id);
            $('input[name="year_name"]').val(response.year.year_name);
            $('select[name="year_status"]').val(response.year.year_status);

            var option = '';
            var selected = ''
            $.each(response.strategic, function (i, item) {
                selected = item.count_strategic == 0 ? '' : 'selected';
                option += '<option value="' + item.id + '" ' + selected + '>' + item.strategic_name + '</option>';
            });

            $('#strategic_id').empty().append(option).bootstrapDualListbox('refresh', true);
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
                url: myurl + "/setting/year/destroy",
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

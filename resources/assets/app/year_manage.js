var table = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, "asc"]
    ],
    dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
    ajax: {
        url: myurl + "/setting/year/manage-strategic/lists",
        type: "POST",
        data: function (d) {
            d.filter_year_name = $('input[name="filter_year_name"]').val();
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "strategic_name", name: "strategic_name" },
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

$('#form').on('submit', function (event) {
    $('.year_strategic_detail_detail').each(function () {
        $(this).rules("add", {
            required: true,
        });
    });
});

$('#form').validate({
    ignore: ".ignore",
    rules: {
        strategic_id: {
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
    $('#modal-default #form').attr('action', myurl + '/setting/year/manage-strategic/store');
    $('#modal-default #form input[type="text"], #modal-default #form select').removeClass('is-invalid');
    $('#modal-default #form input[type="text"], #modal-default #form select').val('');
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting/year/manage-strategic/update');
    $('#modal-default #form input[type="text"], #modal-default #form select').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting/year/manage-strategic/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('input[name="id"]').val(response.year.id);
            $('input[name="year_name"]').val(response.year.year_name);
            $('select[name="year_status"]').val(response.year.year_status);

            // var option = '';
            // var selected = ''
            // $.each(response.strategic, function (i, item) {
            //     selected = item.count_strategic == 0 ? '' : 'selected';
            //     option += '<option value="' + item.id + '" ' + selected + '>' + item.strategic_name + '</option>';
            // });

            // $('#strategic_id').empty().append(option).bootstrapDualListbox('refresh', true);
        }
    });
}

$('input[name="flag_sub"]').on('click', function () {
    if (this.checked) {
        $(".sub_show").show();
        var row = '';
        row += '<tr id="0">'
        row += '<td>'
        row += '<div class="form-group">'
        row += '<input type="text" class="form-control year_strategic_detail_detail" name="year_strategic_detail_detail[0]"  id="year_strategic_detail_detail_0" placeholder="ชื่อย่อย">'
        row += '</div>'
        row += '</td>'
        row += '<td><div style="margin-top: 7px">'
        row += '<a href="#" class="remove_row"><i class="fa fa-minus-circle" aria-hidden="true" style="color: red"></i></a>'
        row += '</div></td>'
        row += '</tr>'
        $('#tb_sub tbody').empty().html(row);
    } else {
        $(".sub_show").hide();
        $('#tb_sub tbody').empty();
    }
});

function add_row() {
    var num_row = parseInt($('#tb_sub tbody tr:last').attr('id')) + 1;
    var row = '';
    row += '<tr id="' + num_row +'">'
    row += '<td>'
    row += '<div class="form-group">'
    row += '<input type="text" class="form-control year_strategic_detail_detail" name="year_strategic_detail_detail[' + num_row + ']"  id="year_strategic_detail_detail_' + num_row +'" placeholder="ชื่อย่อย">'
    row += '</div>'
    row += '</td>'
    row += '<td><div style="margin-top: 7px">'
    row += '<a href="#" class="remove_row"><i class="fa fa-minus-circle" aria-hidden="true" style="color: red"></i></a>'
    row += '</div></td>'
    row += '</tr>'
    $('#tb_sub tbody').append(row);
}

$("#tb_sub").on('click', '.remove_row', function () {
    $(this).parent().parent().parent().remove();
});




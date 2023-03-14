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
            d.year_id = year_id;
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "strategic_name", name: "strategic_name" },
        { data: "strategic_detail", name: "strategic_detail" },
        { data: "flag_sub_strategic", name: "flag_sub_strategic" },
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
            remote: {
                url: myurl + '/setting/year/manage-strategic/check',
                type: 'POST',
                data: {
                    year_id: function () {
                        return $('input[name="year_id"]').val();
                    },
                    strategic_id: function () {
                        return $('select[name="strategic_id"]').val();
                    },
                },
            }
        },
    },
    messages: {
        strategic_id: {
            remote: 'มีข้อมูลนี้อยู่ในระบบแล้ว',
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
    $('select[name="strategic_id"]').removeClass('ignore');
    $('#tb_sub tbody').empty();
    $('.sub_show').hide();
    $('input[name="flag_sub"]').prop('checked', false);
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting/year/manage-strategic/update');
    $('#modal-default #form input[type="text"], #modal-default #form select').removeClass('is-invalid');
    $('select[name="strategic_id"]').addClass('ignore');
    $.ajax({
        type: "POST",
        url: myurl + '/setting/year/manage-strategic/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('input[name="id"]').val(response.id);
            $('select[name="strategic_id"]').val(response.strategic_id);
            $('input[name="flag_sub"]').prop('checked', (response.flag_sub_strategic == 'yes') ? true : false);
            // if (response.get_year_strategic_detail.length > 0) {
            //     var row = '';
            //     $.each(response.get_year_strategic_detail, function (index, value) {
            //         row += '<tr id="' + index + '">'
            //         row += '<td>'
            //         row += '<div class="form-group">'
            //         row += '<input type="text" class="form-control year_strategic_detail_detail" name="year_strategic_detail_detail[' + index + ']"  id="year_strategic_detail_detail_' + index + '" placeholder="' + lang_action.placeholder + '" autocomplete="off" value="' + value.year_strategic_detail_detail + '">'
            //         row += '</div>'
            //         row += '</td>'
            //         row += '<td><div style="margin-top: 7px">'
            //         row += '<a href="#" class="remove_row"><i class="fa fa-minus-circle" aria-hidden="true" style="color: red"></i></a>'
            //         row += '</div></td>'
            //         row += '</tr>'
            //     });

            //     $('#tb_sub tbody').empty().html(row);
            //     $('.sub_show').show();
            // } else {
            //     $('input[name="flag_sub"]').prop('checked', false);
            //     $('#tb_sub tbody').empty();
            //     $('.sub_show').hide();
            // }

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
        row += '<input type="text" class="form-control year_strategic_detail_detail" name="year_strategic_detail_detail[0]"  id="year_strategic_detail_detail_0" placeholder="' + lang_action.placeholder + '" autocomplete="off">'
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
    row += '<tr id="' + num_row + '">'
    row += '<td>'
    row += '<div class="form-group">'
    row += '<input type="text" class="form-control year_strategic_detail_detail" name="year_strategic_detail_detail[' + num_row + ']"  id="year_strategic_detail_detail_' + num_row + '" placeholder="' + lang_action.placeholder + '" autocomplete="off">'
    row += '</div>'
    row += '</td>'
    row += '<td><div style="margin-top: 7px">'
    row += '<a href="#" class="remove_row"><i class="fa fa-minus-circle" aria-hidden="true" style="color: red"></i></a>'
    row += '</div></td>'
    row += '</tr>'
    $('#tb_sub tbody').append(row);
}

$("#tb_sub").on('click', '.remove_row', function () {
    // console.log();
    if ($(this).closest('table').find('tbody tr').length > 1) {
        $(this).closest('tr').remove();
    } else {
        Swal.fire(
            'แจ้งเตือน!',
            'คุณต้องมีข้อมูลอย่างน้อย 1 แถว',
            'warning'
        )
    }
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
                url: myurl + "/setting/year/manage-strategic/destroy",
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

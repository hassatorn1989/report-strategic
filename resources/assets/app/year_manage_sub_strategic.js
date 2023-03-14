var table = $("#example1").DataTable({
    processing: true,
    serverSide: true,
    searching: false,
    order: [
        [0, "asc"]
    ],
    dom: '<"float-left"><"float-right"f>rt<"row"<"col-sm-4"l><"col-sm-4"i><"col-sm-4"p>>',
    ajax: {
        url: myurl + "/setting/year/manage-sub-strategic/lists",
        type: "POST",
        data: function (d) {
            d.filter_year_name = $('input[name="filter_year_name"]').val();
            d.year_strategic_id = year_strategic_id;
        }
    },
    columns: [
        { data: null, sortable: false, searchable: false, className: "text-center" },
        { data: "year_strategic_detail_detail", name: "year_strategic_detail_detail" },
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


function add_data() {
    $("#modal-default .modal-title").text(lang.title_add);
    $('#modal-default #form').attr('action', myurl + '/setting/year/manage-sub-strategic/store');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $('#modal-default #form input[type="text"]').val('');
}

function edit_data(id) {
    $('#modal-default .modal-title').text(lang.title_edit);
    $('#modal-default #form').attr('action', myurl + '/setting/year/manage-sub-strategic/update');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $.ajax({
        type: "POST",
        url: myurl + '/setting/year/manage-sub-strategic/edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('input[name="id"]').val(response.id);
            $('input[name="year_strategic_detail_detail"]').val(response.year_strategic_detail_detail);
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
                url: myurl + "/setting/year/manage-sub-strategic/destroy",
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

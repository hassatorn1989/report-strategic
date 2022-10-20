function get_project(id, strategic_name) {
    $("#modal-detail-strategic .modal-title").text('รายการโครงการ' + strategic_name);
    $.ajax({
        type: "POST",
        url: myurl + "/home/get-project",
        data: {
            year_strategic_id: id
        },
        dataType: "json",
        success: function (response) {
            var row1 = "";
            if (response.project1.length > 0) {
                $.each(response.project1, function (index, item) {
                    row1 += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.project_name}</td>
                    <td>${Number(parseFloat(item.project_budget).toFixed(2)).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
                </tr>`;
                });
            } else {
                row1 += `<tr>
                    <td colspan="3"><div style="text-align:center"><span class="text-danger">ไม่มีข้อมูล</span></div></td>
                    </tr>`;
            }
            $("#project1 tbody").empty().append(row1);

            var row2 = "";
            if (response.project2.length > 0) {
                $.each(response.project2, function (index, item) {
                    row2 += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.project_name}</td>
                    <td>${Number(parseFloat(item.project_budget).toFixed(2)).toLocaleString(undefined, { minimumFractionDigits: 2 }) }</td>
                </tr>`;
                });
            } else {
                row2 += `<tr>
                    <td colspan="3"><div style="text-align:center"><span class="text-danger">ไม่มีข้อมูล</span></div></td>
                    </tr>`;
            }
            $("#project2 tbody").empty().append(row2);

            var row3 = "";
            if (response.project3.length > 0) {
                $.each(response.project3, function (index, item) {
                    row3 += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.project_name}</td>
                    <td>${Number(parseFloat(item.project_budget).toFixed(2)).toLocaleString(undefined, { minimumFractionDigits: 2 }) }</td>
                </tr>`;
                });
            } else {
                row3 += `<tr>
                    <td colspan="3"><div style="text-align:center"><span class="text-danger">ไม่มีข้อมูล</span></div></td>
                    </tr>`;
            }
            $("#project3 tbody").empty().append(row3);
        }
    });
}


function get_project_detail(id, strategic_name, year_strategic_detail_detail) {
    $("#modal-detail-strategic .modal-title").text('รายการโครงการ' + strategic_name + ' (' + year_strategic_detail_detail + ')');
    $.ajax({
        type: "POST",
        url: myurl + "/home/get-project-detail",
        data: {
            year_strategic_detail_id: id
        },
        dataType: "json",
        success: function (response) {
            var row1 = "";
            if (response.project1.length > 0) {
                $.each(response.project1, function (index, item) {
                    row1 += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.project_name}</td>
                    <td>${Number(parseFloat(item.project_budget).toFixed(2)).toLocaleString(undefined, { minimumFractionDigits: 2 })}</td>
                </tr>`;
                });
            } else {
                row1 += `<tr>
                    <td colspan="3"><div style="text-align:center"><span class="text-danger">ไม่มีข้อมูล</span></div></td>
                    </tr>`;
            }
            $("#project1 tbody").empty().append(row1);

            var row2 = "";
            if (response.project2.length > 0) {
                $.each(response.project2, function (index, item) {
                    row2 += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.project_name}</td>
                    <td>${Number(parseFloat(item.project_budget).toFixed(2)).toLocaleString(undefined, { minimumFractionDigits: 2 }) }</td>
                </tr>`;
                });
            } else {
                row2 += `<tr>
                    <td colspan="3"><div style="text-align:center"><span class="text-danger">ไม่มีข้อมูล</span></div></td>
                    </tr>`;
            }
            $("#project2 tbody").empty().append(row2);

            var row3 = "";
            if (response.project3.length > 0) {
                $.each(response.project3, function (index, item) {
                    row3 += `<tr>
                    <td>${index + 1}</td>
                    <td>${item.project_name}</td>
                    <td>${Number(parseFloat(item.project_budget).toFixed(2)).toLocaleString(undefined, { minimumFractionDigits: 2 }) }</td>
                </tr>`;
                });
            } else {
                row3 += `<tr>
                    <td colspan="3"><div style="text-align:center"><span class="text-danger">ไม่มีข้อมูล</span></div></td>
                    </tr>`;
            }
            $("#project3 tbody").empty().append(row3);
        }
    });
}

function validate_number(evt) {
    var theEvent = evt || window.event;

    // Handle paste
    if (theEvent.type === 'paste') {
        key = event.clipboardData.getData('text/plain');
    } else {
        // Handle key press
        var key = theEvent.keyCode || theEvent.which;
        key = String.fromCharCode(key);
    }
    var regex = /[0-9]|\./;
    if (!regex.test(key)) {
        theEvent.returnValue = false;
        if (theEvent.preventDefault) theEvent.preventDefault();
    }
}

//Bootstrap Duallistbox
$('.duallistbox').bootstrapDualListbox()


$('#form_publish').validate({
    ignore: ".ignore",
    rules: {
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
        $.ajax({
            type: "POST",
            url: myurl + "/setting-project/project/manage/check-publish",
            data: {
                id: $('#form_publish input[name="id"]').val()
            },
            success: function (response) {
                if (response == 'true') {
                    var title = ($('#form_publish input[name="project_status"]').val() == 'publish') ? 'ต้องการเผยแพร่โครงการนี้ใช่หรือไม่' : 'ต้องการยกเลิกเผยแพร่โครงการนี้ใช่หรือไม่';
                    Swal.fire({
                        title: title,
                        icon: 'question',
                        showCancelButton: true,
                        cancelButtonColor: '#d33',
                        confirmButtonText: lang_action.destroy_ok,
                        cancelButtonText: lang_action.destroy_cancle
                    }).then((result) => {
                        if (result.value) {
                            $('#btn_publish').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
                            form.submit();
                        }
                    });

                } else {
                    Swal.fire(
                        'แจ้งเตือน!',
                        'กรุณากรอกข้อมูลให้ครบถ้วน',
                        'warning'
                    )
                }
            }
        });

    }
});


$('#form_update').validate({
    ignore: ".ignore",
    rules: {
        project_code: {
            required: true,
        },
        project_name: {
            required: true,
        },
        project_type_id: {
            required: true,
        },
        project_budget: {
            required: true,
        },
        project_period: {
            required: true,
        },
        year_strategic_id: {
            required: true,
        },
        year_strategic_detail_id: {
            required: true,
        },
        budget_id: {
            required: true,
        },
        budget_specify_other: {
            required: true,
        },
        project_main_id: {
            required: true,
        },
        project_sub_type_id: {
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
        $('#btn_save_project').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        form.submit();
    }
});


$('select[name="year_strategic_id"]').on('change', function () {
    var option = `<option value="">${lang_action.select}</option>`;
    if ($(this).find(':selected').data('year_strategic_detail_count') > 0) {
        // console.log($(this).find(':selected').data('year_strategic_detail'));
        $.each($(this).find(':selected').data('year_strategic_detail'), function (index, item) {
            option += `<option value="${item.id}">${item.year_strategic_detail_detail}</option>`;
        });
        $('select[name="year_strategic_detail_id"]').empty().append(option).prop('disabled', false);
    } else {
        $('select[name="year_strategic_detail_id"]').empty().append(option).prop('disabled', true)
    }
});

$('select[name="budget_id"]').on('change', function () {
    var option = `<option value="">${lang_action.select}</option>`;
    if ($(this).find(':selected').data('budget_specify_status') == 'active') {
        $('input[name="budget_specify_other"]').prop('disabled', false).val('');
    } else {
        $('input[name="budget_specify_other"]').prop('disabled', true).val('');
    }
});


$("div#myDropzone").dropzone({
    url: myurl + '/setting-project/project/manage/output-gallery-store',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFilesize: 5,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    dictDefaultMessage: "เลือกหรือลากไฟล์วางที่นี่เพื่ออัปโหลด",
    dictRemoveFile: 'ลบรูปภาพ',
    dictFileTooBig: 'ไฟล์มีขนาดใหญ่เกินไป',
    dictInvalidFileType: 'ไม่สามารถอัปโหลดไฟล์นี้ได้',
    // aut
    init: function () {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("btn_save_gallery_project_output").addEventListener("click", function (e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();

        });

        this.on("sendingmultiple", function (data, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("project_output_id", $('input[name="project_output_id"]').val());
            $('#btn_save_gallery_project_output').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        });

        this.on("successmultiple", function (files, response) {
            location.reload();
        })

        Dropzone.autoDiscover = false;
    }
});

$('a[data-toggle="pill"]').on('show.bs.tab', function (e) {
    localStorage.setItem('activeTab', $(e.target).attr('href'));
});
var activeTab = localStorage.getItem('activeTab');
if (activeTab) {
    $('#vert-tabs-tab a[href="' + activeTab + '"]').tab('show');
}

function cb(start, end) {
    $('input[name=project_period]').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
}

$('input[name="project_period"]').daterangepicker({
    showDropdowns: true,
    startDate: project_period.start,
    endDate: project_period.end,
    locale: {
        format: 'DD/MM/YYYY',
        "separator": " - ",
        "applyLabel": "เลือก",
        "cancelLabel": "ยกเลิก",
        "fromLabel": "จาก",
        "toLabel": "ถึง",
        "customRangeLabel": "กำหนดเอง",
        "daysOfWeek": [
            "อา.",
            "จ.",
            "อ.",
            "พ.",
            "พฤ.",
            "ศ.",
            "ส."
        ],
        "monthNames": [
            "มกราคม",
            "กุมภาพันธ์",
            "มีนาคม",
            "เมษายน",
            "พฤษภาคม",
            "มิถุนายน",
            "กรกฎาคม",
            "สิงหาคม",
            "กันยายน",
            "ตุลาคม",
            "พฤศจิกายน",
            "ธันวาคม"
        ],
    }
}, cb);


//------------------------------project-location------------------------

$('select[name="pcode"]').on('change', function () {
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/get-location-district',
        data: {
            pcode: $(this).val(),
        },
        dataType: "json",
        success: function (response) {
            var option = `<option value="">${lang_action.select}</option>`;
            $.each(response, function (index, item) {
                option += `<option value="${item.acode}">${item.acode}-${item.aname}</option>`;
            });
            $('select[name="acode"]').empty().append(option);
            $('select[name="tcode"]').empty().append(`<option value="">${lang_action.select}</option>`);
            $('select[name="mcode"]').empty().append(`<option value="">${lang_action.select}</option>`);
        }
    });
});

$('select[name="acode"]').on('change', function () {
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/get-location-subdistrict',
        data: {
            acode: $(this).val(),
        },
        dataType: "json",
        success: function (response) {
            var option = `<option value="">${lang_action.select}</option>`;
            $.each(response, function (index, item) {
                option += `<option value="${item.tcode}">${item.tcode}-${item.tname}</option>`;
            });
            option += `<option value="no">ไม่ระบุ</option>`;
            $('select[name="tcode"]').empty().append(option);
            $('select[name="mcode"]').empty().append(`<option value="">${lang_action.select}</option>`);
        }
    });
});

$('select[name="tcode"]').on('change', function () {
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/get-location-village',
        data: {
            tcode: $(this).val(),
        },
        dataType: "json",
        success: function (response) {
            var option = `<option value="">${lang_action.select}</option>`;
            $.each(response, function (index, item) {
                option += `<option value="${item.mcode}">${item.mcode}-${item.mname}</option>`;
            });
            option += `<option value="no">ไม่ระบุ</option>`;
            $('select[name="mcode"]').empty().append(option);
        }
    });
});

$('#form-project-location').validate({
    ignore: ".ignore",
    rules: {
        pcode: {
            required: true,
        },
        acode: {
            required: true,
        },
        tcode: {
            required: true,
        },
        mcode: {
            required: true,
        },
        // address: {
        //     required: true,
        // },
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
        $('#btn_save_project_location').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        form.submit();
    }
});

function add_data_project_location() {
    $('#modal-manage-project-location .modal-title').text('เพิ่มข้อมูลดำเนินการ');
    $('#form-project-location').attr('action', myurl + '/setting-project/project/manage/location-store');
    $('#form-project-location select, #form-project-location input[type="text"]').removeClass('is-invalid').val('');
    $('#form-project-location select[name="acode"]').empty().append(`<option value="">${lang_action.select}</option>`);
    $('#form-project-location select[name="tcode"]').empty().append(`<option value="">${lang_action.select}</option>`);
    $('#form-project-location select[name="mcode"]').empty().append(`<option value="">${lang_action.select}</option>`);
}

function edit_data_project_location(id) {
    $('#form-project-location').attr('action', myurl + '/setting-project/project/manage/location-update');
    $('#form-project-location select, #form-project-location input[type="text"]').removeClass('is-invalid');
    $('#modal-manage-project-location .modal-title').text('แก้ไขข้อมูลพื้นที่ดำเนินการ');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/location-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            var option = `<option value="">${lang_action.select}</option>`;
            $.each(response.get_district, function (index, item) {
                option += `<option value="${item.acode}">${item.acode}-${item.aname}</option>`;
            });
            $('select[name="acode"]').empty().append(option);

            var option = `<option value="">${lang_action.select}</option>`;
            $.each(response.get_subdistrict, function (index, item) {
                option += `<option value="${item.tcode}">${item.tcode}-${item.tname}</option>`;
            });
            option += `<option value="no">ไม่ระบุ</option>`;
            $('select[name="tcode"]').empty().append(option);

            var option = `<option value="">${lang_action.select}</option>`;
            $.each(response.get_village, function (index, item) {
                option += `<option value="${item.mcode}">${item.mcode}-${item.mname}</option>`;
            });
            option += `<option value="no">ไม่ระบุ</option>`;
            $('select[name="mcode"]').empty().append(option);

            $('#form-project-location input[name="id"]').val(response.id);
            $('#form-project-location select[name="pcode"]').val(response.pcode);
            $('#form-project-location select[name="acode"]').val(response.acode);
            $('#form-project-location select[name="tcode"]').val(response.tcode);
            $('#form-project-location select[name="mcode"]').val(response.mcode);
            $('#form-project-location input[name="address"]').val(response.address);

        }
    });
}

function destroy_project_location(id) {
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
                url: myurl + "/setting-project/project/manage/location-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-location------------------------

//------------------------------project-responsible-person------------------------

$('#form-project-responsible-person').validate({
    ignore: ".ignore",
    rules: {
        project_responsible_person_name: {
            required: true,
        },
        project_responsible_person_tel: {
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
        $('#btn_save_project_responsible_person').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_responsible_person() {
    $('#form-project-responsible-person').attr('action', myurl + '/setting-project/project/manage/responsible-person-store');
    $('#form-project-responsible-person input[type="text"]').removeClass('is-invalid').val('');
    $('#project_responsible_person_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_responsible_person(id) {
    $('#form-project-responsible-person').attr('action', myurl + '/setting-project/project/manage/responsible-person-update');
    $('#form-project-responsible-person input[type="text"]').removeClass('is-invalid');
    $('#project_responsible_person_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/responsible-person-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-responsible-person input[name="id"]').val(response.id);
            $('#form-project-responsible-person input[name="project_responsible_person_name"]').val(response.project_responsible_person_name);
            $('#form-project-responsible-person input[name="project_responsible_person_tel"]').val(response.project_responsible_person_tel);
        }
    });
}



function destroy_project_responsible_person(id) {
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
                url: myurl + "/setting-project/project/manage/responsible-person-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-responsible-person------------------------


//------------------------------project-target-group------------------------

$('#form-project-target-group').validate({
    ignore: ".ignore",
    rules: {
        project_target_group_detail: {
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
        $('#btn_save_project_target_group').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_target_group() {
    $('#form-project-target-group').attr('action', myurl + '/setting-project/project/manage/target-group-store');
    $('#form-project-target-group input[type="text"]').removeClass('is-invalid').val('');
    $('#project_target_group_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_target_group(id) {
    $('#form-project-target-group').attr('action', myurl + '/setting-project/project/manage/target-group-update');
    $('#form-project-target-group input[type="text"]').removeClass('is-invalid');
    $('#project_target_group_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/target-group-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-target-group input[name="id"]').val(response.id);
            $('#form-project-target-group input[name="project_target_group_detail"]').val(response.project_target_group_detail);
        }
    });
}

function destroy_project_target_group(id) {
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
                url: myurl + "/setting-project/project/manage/target-group-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-target-group------------------------



//------------------------------project-problem------------------------

$('#form-project-problem').validate({
    ignore: ".ignore",
    rules: {
        project_problem_detail: {
            required: true,
        },
        project_problem_sub_detail: {
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
        $('#btn_save_project_problem').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_problem() {
    $('#form-project-problem').attr('action', myurl + '/setting-project/project/manage/problem-store');
    $('#form-project-problem input[type="text"], #form-project-problem textarea').removeClass('is-invalid').val('');
    // $('#project_problem_mode').text('เพิ่มข้อมูล');
    $("#modal-problem .modal-title").text('เพิ่มข้อมูลปัญหา');
}

function edit_data_project_problem(id) {
    $('#form-project-problem').attr('action', myurl + '/setting-project/project/manage/problem-update');
    $('#form-project-problem input[type="text"]').removeClass('is-invalid');
    $("#modal-problem .modal-title").text('แก้ไขข้อมูลปัญหา');
    // $('#project_problem_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/problem-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-problem input[name="id"]').val(response.id);
            $('#form-project-problem input[name="project_problem_detail"]').val(response.project_problem_detail);
            $('#form-project-problem textarea[name="project_problem_sub_detail"]').val(response.project_problem_sub_detail.replace(/<br\s*\/?>/gi, ""));
        }
    });
}

function destroy_project_problem(id) {
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
                url: myurl + "/setting-project/project/manage/problem-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-problem------------------------


//------------------------------project-problem-solution------------------------

$('#form-project-problem-solution').validate({
    ignore: ".ignore",
    rules: {
        project_problem_solution_detail: {
            required: true,
        },
        project_problem_solution_budget: {
            required: true,
        },
        project_problem_solution_sub_detail: {
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
        $('#btn_save_project_problem_solution').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_problem_solution() {
    $('#form-project-problem-solution').attr('action', myurl + '/setting-project/project/manage/problem-solution-store');
    $('#form-project-problem-solution input[type="text"], #form-project-problem-solution input[type="number"], #form-project-problem-solution textarea').removeClass('is-invalid').val('');
    // $('#project_problem_solution_mode').text('เพิ่มข้อมูล');
    $("#modal-problem-solution .modal-title").text('เพิ่มข้อมูลวิธีแก้ไขปัญหา');
}

function edit_data_project_problem_solution(id) {
    $('#form-project-problem-solution').attr('action', myurl + '/setting-project/project/manage/problem-solution-update');
    $('#form-project-problem-solution input[type="text"], #form-project-problem-solution input[type="number"], #form-project-problem-solution textarea').removeClass('is-invalid');
    $('#modal-problem-solution .modal-title').text('แก้ไขข้อมูลวิธีแก้ไขปัญหา');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/problem-solution-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-problem-solution input[name="id"]').val(response.id);
            $('#form-project-problem-solution input[name="project_problem_solution_detail"]').val(response.project_problem_solution_detail);
            $('#form-project-problem-solution input[name="project_problem_solution_budget"]').val(response.project_problem_solution_budget);
            $('#form-project-problem-solution textarea[name="project_problem_solution_sub_detail"]').val(response.project_problem_solution_sub_detail.replace(/<br\s*\/?>/gi, ""));

        }
    });
}

function destroy_project_problem_solution(id) {
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
                url: myurl + "/setting-project/project/manage/problem-solution-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-problem-solution------------------------


//------------------------------project-quantitative-indicators------------------------

$('#form-project-quantitative-indicators').validate({
    ignore: ".ignore",
    rules: {
        project_quantitative_indicators_value: {
            required: true,
        },
        project_quantitative_indicators_unit: {
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
        $('#btn_save_project_quantitative_indicators').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_quantitative_indicators() {
    $('#form-project-quantitative-indicators').attr('action', myurl + '/setting-project/project/manage/quantitative-indicators-store');
    $('#form-project-quantitative-indicators input[type="text"]').removeClass('is-invalid').val('');
    $('#project_quantitative_indicators_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_quantitative_indicators(id) {
    $('#form-project-quantitative-indicators').attr('action', myurl + '/setting-project/project/manage/quantitative-indicators-update');
    $('#form-project-quantitative-indicators input[type="text"]').removeClass('is-invalid');
    $('#project_quantitative_indicators_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/quantitative-indicators-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-quantitative-indicators input[name="id"]').val(response.id);
            $('#form-project-quantitative-indicators input[name="project_quantitative_indicators_value"]').val(response.project_quantitative_indicators_value);
            $('#form-project-quantitative-indicators input[name="project_quantitative_indicators_unit"]').val(response.project_quantitative_indicators_unit);
        }
    });
}

function destroy_project_quantitative_indicators(id) {
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
                url: myurl + "/setting-project/project/manage/quantitative-indicators-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-quantitative-indicators------------------------


//------------------------------project-qualitative-indicators------------------------

$('#form-project-qualitative-indicators').validate({
    ignore: ".ignore",
    rules: {
        project_qualitative_indicators_value: {
            required: true,
        },
        project_qualitative_indicators_unit: {
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
        $('#btn_save_project_qualitative_indicators').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_qualitative_indicators() {
    $('#form-project-qualitative-indicators').attr('action', myurl + '/setting-project/project/manage/qualitative-indicators-store');
    $('#form-project-qualitative-indicators input[type="text"]').removeClass('is-invalid').val('');
    $('#project_qualitative_indicators_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_qualitative_indicators(id) {
    $('#form-project-qualitative-indicators').attr('action', myurl + '/setting-project/project/manage/qualitative-indicators-update');
    $('#form-project-qualitative-indicators input[type="text"]').removeClass('is-invalid');
    $('#project_qualitative_indicators_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/qualitative-indicators-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-qualitative-indicators input[name="id"]').val(response.id);
            $('#form-project-qualitative-indicators input[name="project_qualitative_indicators_value"]').val(response.project_qualitative_indicators_value);
            $('#form-project-qualitative-indicators input[name="project_qualitative_indicators_unit"]').val(response.project_qualitative_indicators_unit);
        }
    });
}

function destroy_project_qualitative_indicators(id) {
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
                url: myurl + "/setting-project/project/manage/qualitative-indicators-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-qualitative-indicators------------------------


//------------------------------project-output------------------------

$('#form-project-output').validate({
    ignore: ".ignore",
    rules: {
        project_output_detail: {
            required: true,
        },
        indicators_output_type: {
            required: true,
        },
        indicators_output_id: {
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
        $('#btn_save_project_output').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        form.submit();
    }
});

$('input[name="indicators_output_type"]').on('change', function () {
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/get-project-indicators',
        data: {
            indicators_type: $(this).val(),
            project_id: project_id
        },
        dataType: "json",
        success: function (response) {
            var option = '<option value="">' + lang_action.select + '</option>';
            $.each(response, function (index, value) {
                option += '<option value="' + value.id + '">' + value.indicators_value + ' (' + value.indicators_unit + ')</option>';
            });
            $('select[name="indicators_output_id"]').empty().append(option);
        }
    });
});

function add_data_project_output() {
    $('#form-project-output').attr('action', myurl + '/setting-project/project/manage/output-store');
    $('#form-project-output input[type="text"], #form-project-output select, #form-project-output textarea').removeClass('is-invalid').val('');
    $("#modal-project-output .modal-title").text('เพิ่มข้อมูลผลผลิต');
    $('#form-project-output input[name="indicators_output_type"]').prop('checked', false);
    $('#form-project-output select[name="indicators_output_id"]').empty().append('<option value="">' + lang_action.select + '</option>');
}

function edit_data_project_output(id) {
    $('#form-project-output').attr('action', myurl + '/setting-project/project/manage/output-update');
    $('#form-project-output input[type="text"], #form-project-output select, #form-project-output textarea').removeClass('is-invalid');
    $("#modal-project-output .modal-title").text('แก้ไขข้อมูลผลผลิต');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/output-edit',
        data: {
            id: id,
            project_id: project_id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-output input[name="id"]').val(response.output.id);
            $('#form-project-output input[name="project_output_detail"]').val(response.output.project_output_detail);
            if (response.output.indicators_type == 'qualitative') {
                $('#form-project-output input[name="indicators_output_type"][value="qualitative"]').prop('checked', true);
            } else {
                $('#form-project-output input[name="indicators_output_type"][value="quantitative"]').prop('checked', true);
            }
            var option = '<option value="">' + lang_action.select + '</option>';
            $.each(response.indicators, function (index, value) {
                option += '<option value="' + value.id + '">' + value.indicators_value + ' (' + value.indicators_unit + ')</option>';
            });
            $('select[name="indicators_output_id"]').empty().append(option);
            $('#form-project-output select[name="indicators_output_id"]').val(response.output.indicators_id)
            $('#form-project-output textarea[name="project_output_upgrading"]').val(response.output.project_output_upgrading)
        }
    });
}

function destroy_project_output(id) {
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
                url: myurl + "/setting-project/project/manage/output-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}


function manage_gallery_project_output(id) {
    $('#modal-manage-gallery-project-output .modal-title').text('จัดการอัลบั้มภาพ');
    $('input[name="project_output_id"]').val(id)
}

function manage_output_gallery_show(id) {
    $('#modal-manage-gallery-project-output-view .modal-title').text('แสดงอัลบั้มภาพ');
    $('#modal-manage-gallery-project-output-view input[name="project_output_id"]').val(id);
    $.ajax({
        type: "POST",
        url: myurl + "/setting-project/project/manage/output-gallery-show",
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            var row = '';
            if (response.length > 0) {
                $.each(response, function (index, item) {
                    row += `
                    <div class="col-md-4">
                        <div class="card">
                            <img class="card-img-top" src="${myurl}/storage/app/${item.project_output_gallery_path}" >
                            <div class="card-body">
                                <div  style="text-align:center;">
                                    <button type="button" class="btn btn-danger btn-sm remove_row_output" value="${item.id}"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                `
                });
            } else {
                row += `
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div  style="text-align:center;">
                                <h5>ไม่พบข้อมูล</h5>
                            </div>
                        </div>
                    </div>
                </div>
            `
            }
            $('#modal-manage-gallery-project-output-view .modal-body .show_gallery').empty().append(row);
        }
    });
}


$(".show_gallery").on('click', '.remove_row_output', function () {
    var project_output_id = $('#modal-manage-gallery-project-output-view input[name="project_output_id"]').val()
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
                url: myurl + "/setting-project/project/manage/output-gallery-destroy",
                data: {
                    id: $(this).val(),
                    project_output_id: project_output_id
                },
                success: function (response) {
                    var count_image = (response.project_output.count_id > 0) ? `<a href="#" data-toggle="modal" data-target="#modal-manage-gallery-project-output-view" onclick="manage_output_gallery_show('{{ $item->id }}')">${response.project_output.count_id} รูป</a>` : `-`;
                    $(`#count_image_${project_output_id}`).empty().append(count_image);
                }
            });
        }
        $(this).closest('.col-md-4').remove();
    });

});
//------------------------------end-project-output------------------------

//------------------------------project-outcome------------------------

$('#form-project-outcome').validate({
    ignore: ".ignore",
    rules: {
        project_outcome_detail: {
            required: true,
        },
        indicators_outcome_type: {
            required: true,
        },
        indicators_outcome_id: {
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
        $('#btn_save_project_outcome').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        form.submit();
    }
});


$('input[name="indicators_outcome_type"]').on('change', function () {
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/get-project-indicators',
        data: {
            indicators_type: $(this).val(),
            project_id: project_id
        },
        dataType: "json",
        success: function (response) {
            var option = '<option value="">' + lang_action.select + '</option>';
            $.each(response, function (index, value) {
                option += '<option value="' + value.id + '">' + value.indicators_value + ' (' + value.indicators_unit + ')</option>';
            });
            option += '<option value="N">ไม่ระบุ</option>';
            $('select[name="indicators_outcome_id"]').empty().append(option);
        }
    });
});

function add_data_project_outcome() {
    $('#form-project-outcome').attr('action', myurl + '/setting-project/project/manage/outcome-store');
    $('#form-project-outcome input[type="text"], #form-project-outcome select').removeClass('is-invalid');
    $('#form-project-outcome input[name="indicators_outcome_type"]').prop('checked', false);
    $("#modal-project-outcome .modal-title").text('เพิ่มข้อมูลผลลัพธ์');
    $('#form-project-outcome select[name="indicators_outcome_id"]').empty().append('<option value="">' + lang_action.select + '</option>');
}

function edit_data_project_outcome(id) {
    $('#form-project-outcome').attr('action', myurl + '/setting-project/project/manage/outcome-update');
    $('#form-project-outcome input[type="text"], #form-project-outcome select').removeClass('is-invalid');
    $("#modal-project-outcome .modal-title").text('แก้ไขข้อมูลผลลัพธ์');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/outcome-edit',
        data: {
            id: id,
            project_id: project_id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-outcome input[name="id"]').val(response.outcome.id);
            $('#form-project-outcome input[name="project_outcome_detail"]').val(response.outcome.project_outcome_detail);
            if (response.outcome.indicators_type == 'qualitative') {
                $('#form-project-outcome input[name="indicators_outcome_type"][value="qualitative"]').prop('checked', true);
            } else {
                $('#form-project-outcome input[name="indicators_outcome_type"][value="quantitative"]').prop('checked', true);
            }
            var option = '<option value="">' + lang_action.select + '</option>';
            $.each(response.indicators, function (index, value) {
                option += '<option value="' + value.id + '">' + value.indicators_value + ' (' + value.indicators_unit + ')</option>';
            });
            $('select[name="indicators_outcome_id"]').empty().append(option);
            $('#form-project-outcome select[name="indicators_outcome_id"]').val(response.outcome.indicators_id)
        }
    });
}

function destroy_project_outcome(id) {
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
                url: myurl + "/setting-project/project/manage/outcome-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-outcome------------------------

//------------------------------project-impact------------------------

$('#form-project-impact').validate({
    ignore: ".ignore",
    rules: {
        project_impact_detail: {
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
        $('#btn_save_project_impact').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_impact() {
    $('#form-project-impact').attr('action', myurl + '/setting-project/project/manage/impact-store');
    $('#form-project-impact input[type="text"]').removeClass('is-invalid').val('');
    $('#project_impact_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_impact(id) {
    $('#form-project-impact').attr('action', myurl + '/setting-project/project/manage/impact-update');
    $('#form-project-impact input[type="text"]').removeClass('is-invalid');
    $('#project_impact_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/setting-project/project/manage/impact-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-impact input[name="id"]').val(response.id);
            $('#form-project-impact input[name="project_impact_detail"]').val(response.project_impact_detail);
        }
    });
}

function destroy_project_impact(id) {
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
                url: myurl + "/setting-project/project/manage/impact-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

//------------------------------end-project-impact------------------------

$('#form-project-output-detail').validate({
    ignore: ".ignore",
    rules: {
        project_output_detail_produce: {
            required: true,
        },
        project_output_detail_elevate: {
            required: true,
        },
        project_output_detail_process: {
            required: true,
        },
        project_output_detail_image: {
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
        $('#btn_save_project_outout_detail').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...').attr('disabled', true);
        form.submit();
    }
});

function manage_project_output_detail(id, title) {
    $("#modal-project-output-detail .modal-title").text('เพิ่มรายละเอียด : ' + title);
    $('#form-project-output-detail').attr('action', myurl + '/setting-project/project/manage/output-detail-store');
    $('#form-project-output-detail input[type="text"], #form-project-output-detail input[type="file"], #form-project-output-detail textarea').removeClass('is-invalid').val('');
    $('#form-project-output-detail input[name="project_output_id2"]').val(id);
    $('#form-project-output-detail input[name="project_output_detail_image"]').removeClass('ignore');

}


function manage_project_output_detail_edit(id, title) {
    $("#modal-project-output-detail .modal-title").text('แก้ไขรายละเอียด : ' + title);
    $('#form-project-output-detail').attr('action', myurl + '/setting-project/project/manage/output-detail-update');
    $('#form-project-output-detail input[name="project_output_detail_image"]').addClass('ignore');
    $.ajax({
        type: "POST",
        url: myurl + "/setting-project/project/manage/output-detail-edit",
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-output-detail input[name="id"]').val(response.id);
            $('#form-project-output-detail input[name="project_output_detail_produce"]').val(response.project_output_detail_produce);
            $('#form-project-output-detail textarea[name="project_output_detail_process"]').val(response.project_output_detail_process.replace(/<br\s*[\/]?>/gi, ""));
            $('#form-project-output-detail textarea[name="project_output_detail_elevate"]').val(response.project_output_detail_elevate.replace(/<br\s*[\/]?>/gi, ""));
            if (response.project_output_detail_image != '') {
                $('#form-project-output-detail .show_image_output_detail').show();
                $('#form-project-output-detail #project_output_detail_image_show').attr('src', myurl + '/storage/app/' + response.project_output_detail_image);
            } else {
                $('#form-project-output-detail .show_image_output_detail').hide();
                $('#form-project-output-detail #project_output_detail_image_show').attr('src', '');
            }

        }
    });
}

function manage_project_output_detail_destroy(id) {
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
                url: myurl + "/setting-project/project/manage/output-detail-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    });
}

function show_image(path) {
    $('#modal-image #image_show').attr('src', myurl + '/storage/app/' + path);
}

$('#form-project-problem-summary').validate({
    ignore: ".ignore",
    rules: {
        project_problem_summary: {
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
        $('#btn_save_problem_summary').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...').attr('disabled', true);
        form.submit();
    }
});

function get_problem_summary(id) {  
    $.ajax({
        type: "POST",
        url: myurl + "/setting-project/project/manage/get-problem-summary",
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-problem-summary textarea[name="project_problem_summary"]').val(response.project_problem_summary.replace(/<br\s*\/?>/gi, ""));
        }
    });
}

$('#form-project-problem-solution-summary').validate({
    ignore: ".ignore",
    rules: {
        project_problem_solution_summary: {
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
        $('#btn_save_problem_solution_summary').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...').attr('disabled', true);
        form.submit();
    }
});

function add_project_file() { 
    console.log('add_project_file');
    // $('#form-project-file').attr('action', myurl + '/setting-project/project/manage/file-store');
    // $('#form-project-file input[name="id"]').val('');
    // $('#form-project-file input[name="project_file_name"]').val('');
    // $('#form-project-file input[name="project_file"]').val('');
    // $('#form-project-file .show_file').hide();
    // $('#form-project-file #project_file_show').attr('src', '');
    $('#modal-file .modal-title').text('เพิ่มไฟล์');
 }

function get_problem_solution_summary(id) {  
    $.ajax({
        type: "POST",
        url: myurl + "/setting-project/project/manage/get-problem-solution-summary",
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            $('#form-project-problem-solution-summary textarea[name="project_problem_solution_summary"]').val(response.project_problem_solution_summary.replace(/<br\s*\/?>/gi, ""));
        }
    });
}




$("div#myDropzoneFile").dropzone({
    url: myurl + '/setting-project/project/manage/file-store',
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 5,
    maxFilesize: 5,
    acceptedFiles: 'image/*',
    addRemoveLinks: true,
    dictDefaultMessage: "เลือกหรือลากไฟล์วางที่นี่เพื่ออัปโหลด",
    dictRemoveFile: 'ลบรูปภาพ',
    dictFileTooBig: 'ไฟล์มีขนาดใหญ่เกินไป',
    dictInvalidFileType: 'ไม่สามารถอัปโหลดไฟล์นี้ได้',
    // aut
    init: function () {
        dzClosure = this; // Makes sure that 'this' is understood inside the functions below.
        // for Dropzone to process the queue (instead of default form behavior):
        document.getElementById("btn_save_project_file").addEventListener("click", function (e) {
            // Make sure that the form isn't actually being sent.
            e.preventDefault();
            e.stopPropagation();
            dzClosure.processQueue();

        });

        this.on("sendingmultiple", function (data, xhr, formData) {
            formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
            formData.append("file_project_id", $('input[name="file_project_id"]').val());
            $('#btn_save_project_file').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> ' + lang_action.btn_saving).attr('disabled', true);
        });

        this.on("successmultiple", function (files, response) {
            location.reload();
        })

        Dropzone.autoDiscover = false;
    }
});

function manage_project_file_destroy(id) {
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
                url: myurl + "/setting-project/project/manage/file-destroy",
                data: {
                    id: id
                },
                success: function (data) {
                    window.location.reload();
                }
            });
        }
    }); 
}

function approve_project() {
    $('#modal-approve-project #form-check-project select[name="project_status"]').val('');
    $('#modal-approve-project #form-check-project input[name="project_file_name"]').val('');
    $('#modal-approve-project #form-check-project .modal-title').text('ตรวจสอบข้อมูลโครงการ');
}

$('select[name="project_status"]').on('change', function () {
    // console.log($(this).val());
    if ($(this).val() == 'reject') {
        $('.project_status_reject_detail_show').show();
    } else {
        $('.project_status_reject_detail_show').hide();
    }
});

$('#form-check-project').validate({
    ignore: ".ignore",
    rules: {
        project_status: {
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
        $('#btn_save_check_project').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span> กำลังบันทึก...').attr('disabled', true);
        form.submit();
    }
});

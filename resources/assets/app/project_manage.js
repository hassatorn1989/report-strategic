// bsCustomFileInput.init();
// Dropzone.options.myDropzone = {
//     url: myurl + '/project/manage/output-gallery-store',
//     autoProcessQueue: false,
//     uploadMultiple: true,
//     parallelUploads: 5,
//     // maxFiles: 5,
//     maxFilesize: 5,
//     acceptedFiles: 'image/*',
//     addRemoveLinks: true,
//     init: function () {
//         dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

//         // for Dropzone to process the queue (instead of default form behavior):
//         document.getElementById("btn_save_gallery_project_output").addEventListener("click", function (e) {
//             // Make sure that the form isn't actually being sent.
//             e.preventDefault();
//             e.stopPropagation();
//             dzClosure.processQueue();
//         });

//         // //send all the form data along with the files:
//         this.on("sendingmultiple", function (data, xhr, formData) {
//             formData.append("_token", $('meta[name="csrf-token"]').attr('content'));
//             // formData.append("lastname", jQuery("#lastname").val());
//         });
//     }
// }

$("div#myDropzone").dropzone({
    url: myurl + '/project/manage/output-gallery-store',
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
            // console.log("successmultiple");
            // console.log(response);
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


$('input[name="project_period"]').daterangepicker({
    showDropdowns: true,
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
});

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
    $('#form-project-responsible-person').attr('action', myurl + '/project/manage/responsible-person-store');
    $('#form-project-responsible-person input[type="text"]').removeClass('is-invalid').val('');
    $('#project_responsible_person_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_responsible_person(id) {
    $('#form-project-responsible-person').attr('action', myurl + '/project/manage/responsible-person-update');
    $('#form-project-responsible-person input[type="text"]').removeClass('is-invalid');
    $('#project_responsible_person_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/responsible-person-edit',
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
                url: myurl + "/project/manage/responsible-person-destroy",
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
    $('#form-project-target-group').attr('action', myurl + '/project/manage/target-group-store');
    $('#form-project-target-group input[type="text"]').removeClass('is-invalid').val('');
    $('#project_target_group_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_target_group(id) {
    $('#form-project-target-group').attr('action', myurl + '/project/manage/target-group-update');
    $('#form-project-target-group input[type="text"]').removeClass('is-invalid');
    $('#project_target_group_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/target-group-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
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
                url: myurl + "/project/manage/target-group-destroy",
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
        $('#btn_save_project_problem').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_problem() {
    $('#form-project-problem').attr('action', myurl + '/project/manage/problem-store');
    $('#form-project-problem input[type="text"]').removeClass('is-invalid').val('');
    $('#project_problem_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_problem(id) {
    $('#form-project-problem').attr('action', myurl + '/project/manage/problem-update');
    $('#form-project-problem input[type="text"]').removeClass('is-invalid');
    $('#project_problem_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/problem-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-problem input[name="id"]').val(response.id);
            $('#form-project-problem input[name="project_problem_detail"]').val(response.project_problem_detail);
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
                url: myurl + "/project/manage/problem-destroy",
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
        $('#btn_save_project_problem_solution').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_problem_solution() {
    $('#form-project-problem-solution').attr('action', myurl + '/project/manage/problem-solution-store');
    $('#form-project-problem-solution input[type="text"]').removeClass('is-invalid').val('');
    $('#project_problem_solution_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_problem_solution(id) {
    $('#form-project-problem-solution').attr('action', myurl + '/project/manage/problem-solution-update');
    $('#form-project-problem-solution input[type="text"]').removeClass('is-invalid');
    $('#project_problem_solution_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/problem-solution-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-problem-solution input[name="id"]').val(response.id);
            $('#form-project-problem-solution input[name="project_problem_solution_detail"]').val(response.project_problem_solution_detail);
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
                url: myurl + "/project/manage/problem-solution-destroy",
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
    $('#form-project-quantitative-indicators').attr('action', myurl + '/project/manage/quantitative-indicators-store');
    $('#form-project-quantitative-indicators input[type="text"]').removeClass('is-invalid').val('');
    $('#project_quantitative_indicators_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_quantitative_indicators(id) {
    $('#form-project-quantitative-indicators').attr('action', myurl + '/project/manage/quantitative-indicators-update');
    $('#form-project-quantitative-indicators input[type="text"]').removeClass('is-invalid');
    $('#project_quantitative_indicators_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/quantitative-indicators-edit',
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
                url: myurl + "/project/manage/quantitative-indicators-destroy",
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
    $('#form-project-qualitative-indicators').attr('action', myurl + '/project/manage/qualitative-indicators-store');
    $('#form-project-qualitative-indicators input[type="text"]').removeClass('is-invalid').val('');
    $('#project_qualitative_indicators_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_qualitative_indicators(id) {
    $('#form-project-qualitative-indicators').attr('action', myurl + '/project/manage/qualitative-indicators-update');
    $('#form-project-qualitative-indicators input[type="text"]').removeClass('is-invalid');
    $('#project_qualitative_indicators_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/qualitative-indicators-edit',
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
                url: myurl + "/project/manage/qualitative-indicators-destroy",
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
        $('#btn_save_project_output').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_output() {
    $('#form-project-output').attr('action', myurl + '/project/manage/output-store');
    $('#form-project-output input[type="text"]').removeClass('is-invalid').val('');
    $('#project_output_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_output(id) {
    $('#form-project-output').attr('action', myurl + '/project/manage/output-update');
    $('#form-project-output input[type="text"]').removeClass('is-invalid');
    $('#project_output_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/output-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-output input[name="id"]').val(response.id);
            $('#form-project-output input[name="project_output_detail"]').val(response.project_output_detail);
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
                url: myurl + "/project/manage/output-destroy",
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
    $('#modal-manage-gallery-project-output .modal-title').text('จัดการรูปภาพ');
    $('input[name="project_output_id"]').val(id)
}
//------------------------------end-project-output------------------------

//------------------------------project-outcome------------------------

$('#form-project-outcome').validate({
    ignore: ".ignore",
    rules: {
        project_outcome_detail: {
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
        $('#btn_save_project_outcome').empty().html('<span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>').attr('disabled', true);
        form.submit();
    }
});

function add_data_project_outcome() {
    $('#form-project-outcome').attr('action', myurl + '/project/manage/outcome-store');
    $('#form-project-outcome input[type="text"]').removeClass('is-invalid').val('');
    $('#project_outcome_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_outcome(id) {
    $('#form-project-outcome').attr('action', myurl + '/project/manage/outcome-update');
    $('#form-project-outcome input[type="text"]').removeClass('is-invalid');
    $('#project_outcome_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/outcome-edit',
        data: {
            id: id
        },
        dataType: "json",
        success: function (response) {
            console.log(response);
            $('#form-project-outcome input[name="id"]').val(response.id);
            $('#form-project-outcome input[name="project_outcome_detail"]').val(response.project_outcome_detail);
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
                url: myurl + "/project/manage/outcome-destroy",
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
    $('#form-project-impact').attr('action', myurl + '/project/manage/impact-store');
    $('#form-project-impact input[type="text"]').removeClass('is-invalid').val('');
    $('#project_impact_mode').text('เพิ่มข้อมูล');
}

function edit_data_project_impact(id) {
    $('#form-project-impact').attr('action', myurl + '/project/manage/impact-update');
    $('#form-project-impact input[type="text"]').removeClass('is-invalid');
    $('#project_impact_mode').text('แก้ไขข้อมูล');
    $.ajax({
        type: "POST",
        url: myurl + '/project/manage/impact-edit',
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
                url: myurl + "/project/manage/impact-destroy",
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

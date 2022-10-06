$('input[name="project_period"]').daterangepicker({
    // minDate: new Date(),
    // autoApply: true,
    "showDropdowns": true,
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


function add_data() {
    $("#modal-default .modal-title").text(lang.title_add);
    $('#modal-default #form').attr('action', myurl + '/project/manage/store');
    $('#modal-default #form input[type="text"]').removeClass('is-invalid');
    $('#modal-default #form input[type="text"]:input[type="year_name"]').val('');
}

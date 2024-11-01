jQuery(document).ready(function ($) {
    $("input[type=\"datetime\"]").datepicker({

        dateFormat: "yy-mm-dd",
        minDate: 0

    });
    $('.colorpick').each(function () {
        $(this).wpColorPicker();
    });

});
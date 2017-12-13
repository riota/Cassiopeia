
$(document).ready(function(){
$("#mytable #checkall").click(function () {
        if ($("#mytable #checkall").is(':checked')) {
            $("#mytable #checkthis").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable #checkthis").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
    
    $("#mytable #checkall1").click(function () {
        if ($("#mytable #checkall1").is(':checked')) {
            $("#mytable #checkthis1").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#mytable #checkthis1").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
});
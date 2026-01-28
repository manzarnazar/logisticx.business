$(document).ready(function () {
    driverSettings();

    $("#mail_driver").change(driverSettings);

    $("#signature").summernote({
        placeholder: "Enter Email Signature",
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["fontname", "fontsize", "color"]],
            // ["para", ["ul", "ol", "paragraph"]],
            // ["table", ["table"]],
            ["insert", ["link", "picture"]],
        ],
        height: 150,
    });
});

function driverSettings() {
    var mail_driver = $("#mail_driver").val();
    if (mail_driver == "smtp") {
        $(".smtp").show();
        $(".sendmail").hide();
    } else if (mail_driver == "sendmail") {
        $(".sendmail").show();
        $(".smtp").hide();
    } else {
        $(".sendmail").hide();
        $(".smtp").hide();
    }
}

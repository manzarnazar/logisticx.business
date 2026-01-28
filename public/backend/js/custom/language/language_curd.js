"use strict";

$(document).ready(function () {
    $("#icon_class").select2({
        placeholder: $("#icon_class").attr("data-placeholder"),
        templateResult: formatIcon,
        templateSelection: formatIcon,
    });

    function formatIcon(icon) {
        if (!icon) {
            return icon.text;
        }

        return $(
            `<span>
                <i class="${$(icon.element).data("icon")}"></i> ${icon.text} 
            </span>`
        );
    }
});

$("#lang_module").on("change", function (e) {
    var url = $(this).data("url");
    var code = $("#code").val();
    var module = $(this).val();
    var formData = { code: code, module: module };
    $.ajax({
        type: "GET",
        dataType: "json",
        url: url,
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        data: formData,
        success: function (response) {
            // console.log(response);
            $("#termsRow").empty();
            $.each(response.terms, function (key, value) {
                let termsRow = `
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <input class="form-control ot-input" name="name" list="datalistOptions" value="${key}" disabled>
                                </div>
                                <div class="col-md-6 translated_language">
                                    <input class="form-control ot-input" list="datalistOptions" placeholder="${value}" name="${key}" value="${value}">
                                </div>
                            </div>
                            `;
                $("#termsRow").append(termsRow);
            });
        },
        error: function (data) {
            console.log(data);
        },
    });
});

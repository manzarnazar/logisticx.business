"use strict";

$(document).ready(function () {
    enableMerchant();
    $("#type").on("change", () => enableMerchant());

    $("#type").select2({ placeholder: $("#type").data("placeholder") });
    $("#discount_type").select2({
        placeholder: $("#discount_type").data("placeholder"),
    });
});

function enableMerchant() {
    let type = $("#type").val();

    if (type == $("#type").data("merchant")) {
        $("#merchant_id").prop("disabled", false);
        $(".merchant_container").removeClass("d-none");
        searchMerchants();
    } else {
        $("#merchant_id").prop("disabled", true);
        $(".merchant_container").addClass("d-none", true);
    }
}

function searchMerchants() {
    $("#merchant_id").select2({
        ajax: {
            url: $("#merchant_id").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    select2: true,
                    searchQuery: true,
                };
            },
            processResults: function (response) {
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });
}

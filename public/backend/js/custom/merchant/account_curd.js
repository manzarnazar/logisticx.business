"use strict";

$(document).ready(function () {
    changeInputs();
    $("#payment_method").on("change", changeInputs);
});

function changeInputs() {
    console.log("here");
    const PaymentMethod = $("#payment_method").val();
    console.log(PaymentMethod);

    $(".common-input").removeClass("d-none");
    $(".common-input input, .common-input select ").prop("disabled", false);
    $(".bank-input input, .bank-input select").prop("disabled", false);
    $(".mfs-input input, .mfs-input select").prop("disabled", false);

    if (PaymentMethod == "bank") {
        $(".mfs-input").addClass("d-none");
        $(".bank-input").removeClass("d-none");
        $(".mfs-input input, .mfs-input select").prop("disabled", true);
    } else if (PaymentMethod == "mfs") {
        $(".bank-input").addClass("d-none");
        $(".mfs-input").removeClass("d-none");
        $(".bank-input input, .bank-input select").prop("disabled", true);
    } else {
        $(".common-input,.bank-input,.mfs-input").addClass("d-none");
        $(".common-input input, .common-input select ").prop("disabled", true);
        $(".bank-input input, .bank-input select").prop("disabled", true);
        $(".mfs-input input, .mfs-input select").prop("disabled", true);
    }
}

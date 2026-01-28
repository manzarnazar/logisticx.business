"use strict";

$(document).ready(function () {
    updateTotalCashCollection();
    $(document).on("change", ".parcels", updateTotalCashCollection);

    $("#allCheckBox").on("change", function () {
        var isChecked = $(this).prop("checked");
        $(".parcels").prop("checked", isChecked);
        updateTotalCashCollection();
    });
});

function updateTotalCashCollection() {
    var allChecked = $(".parcels:checked").length === $(".parcels").length;
    $("#allCheckBox").prop("checked", allChecked);

    let total_cod = 0;
    let total_charge = 0;
    let totalAmount = 0;

    $(".parcels:checked").each(function () {
        let cod = parseFloat($(this).data("cod")) ?? 0;
        let charge = parseFloat($(this).data("charge")) ?? 0;

        total_cod += cod;
        total_charge += charge;

        if (total_cod >= total_charge) {
            totalAmount = total_cod - total_charge;
        } else {
            total_cod -= cod;
            total_charge -= charge;
            $(this).prop("checked", false);
        }
    });

    $("#amount").val(totalAmount.toFixed(2));
}

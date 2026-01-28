"use strict";

$(document).ready(function () {
    $("#product_category_id").on("change", serviceType);
    $("#service_type_id").on("change", area);
    $("#area").on("change", charge);
});

function resetFields() {
    $("#charge_id").val("");
    $("#delivery_time").val("");
    $("#charge").val("");
    $("#additional_charge").val("");
}

function serviceType() {
    resetFields();
    let mid = $("#merchant_id").val();
    let pcID = $("#product_category_id").val(); //product category id
    let url = $("#service_type_id").data("url");

    if (mid == "" || pcID == "") {
        return;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: { merchant_id: mid, product_category_id: pcID },
        dataType: "html",
        success: function (data) {
            $("#service_type_id").html(data);
        },
    });
    area();
}

function area() {
    resetFields();
    let mid = $("#merchant_id").val();
    let pcID = $("#product_category_id").val(); //product category id
    let stID = $("#service_type_id").val(); //product category id

    if (mid == "" || pcID == "" || stID == "") {
        return;
    }

    $.ajax({
        type: "POST",
        url: $("#area").data("url"),
        data: {
            merchant_id: mid,
            product_category_id: pcID,
            service_type_id: stID,
        },
        dataType: "html",
        success: function (data) {
            $("#area").html(data);
        },
    });
}

function charge() {
    let mid = $("#merchant_id").val();
    let pcID = $("#product_category_id").val();
    let stID = $("#service_type_id").val();
    let area = $("#area").val();

    if (mid == "" || pcID == "" || stID == "" || area == "") {
        return;
    }

    $.ajax({
        type: "POST",
        url: $("#charge_id").data("url"),
        data: {
            merchant_id: mid,
            product_category_id: pcID,
            service_type_id: stID,
            area: area,
        },
        dataType: "json",
        success: function (data) {
            $("#charge_id").val(data.id);
            $("#delivery_time").val(data.delivery_time);
            $("#charge").val(data.charge);
            $("#additional_charge").val(data.additional_charge);
        },
        error: function (xhr, textStatus, errorThrown) {
            resetFields();

            var errorMessage = "An error occurred. Please try again later.";

            if (xhr.responseJSON && xhr.responseJSON.error) {
                errorMessage = xhr.responseJSON.error;
            }
            Swal.fire("Sorry", errorMessage, "error");
        },
    });
}

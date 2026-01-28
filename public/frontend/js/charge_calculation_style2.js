"use strict";

let deliveryCharge = 0.0;
let deliveryZone;
let pickupArea;
let deliveryArea;
let productCategoryId;
let serviceTypeId;

$(document).ready(function () {

    $('#pickupAreaId').on('change', function () {
        detectDeliveryZone();
    });

    $('#deliveryAreaId').on('change', function () {
        detectDeliveryZone();
    });

    $('#productCategoryId').on('change', function () {
        loadServiceTypes();
    });

    $('#serviceTypeId').on('change', function () {
        calculateDeliveryCharge();
    });

});

function detectDeliveryZone() {
    pickupArea      = $("#pickupAreaId").val();
    deliveryArea    = $("#deliveryAreaId").val();

    if (!pickupArea || !deliveryArea) {
        deliveryZone = "outside_city";
        return;
    }

    $.ajax({
        type: "POST",
        url: $("#deliveryZoneDetector").data("url"),
        data: {
            pickup_id: pickupArea,
            destination_id: deliveryArea
        },
        dataType: "json",
        success: (data) => {
            deliveryZone = data.area;
        },
        error: (data) => {
            console.log(data);
        },
    }).always(() => {
        loadServiceTypes();
    });
}

function loadServiceTypes() {
    $("#serviceTypeId").empty().append("<option value=''>Select Service Type</option>");
    $("#serviceTypeId").val("");

    productCategoryId = $("#productCategoryId").val();

    if (!productCategoryId || !deliveryZone) {
        return;
    }

    $("#deliveryCharge").text("Searching Service Types...");

    $.ajax({
        type: "POST",
        url: $("#serviceTypeId").data("url"),
        data: {
            product_category_id: productCategoryId,
            area: deliveryZone
        },
        dataType: "json",
        success: function (data) {
            $("#deliveryCharge").text("");

            if (data.service_types.length === 0) {
                $("#deliveryCharge").text("No Service type found.");
                return;
            }

            for (const type of data.service_types) {
                $("#serviceTypeId").append(
                    `<option value="${type.id}">${type.name}</option>`
                );
            }
        },
        error: function (xhr, status, error) {
            console.log(xhr, status, error);
            $("#deliveryCharge").text("No Service type found.");
        },
    }).always(() => calculateDeliveryCharge());
}

function calculateDeliveryCharge() {
    serviceTypeId = $("#serviceTypeId").val();

    if (!productCategoryId || !serviceTypeId || !deliveryZone) {
        return;
    }

    $("#deliveryCharge").text("Calculating Charge....");

    $.ajax({
        type: "POST",
        url: $("#deliveryCharge").data("url"),
        data: {
            product_category_id: productCategoryId,
            service_type_id: serviceTypeId,
            area: deliveryZone
        },
        dataType: "json",
        success: function (data) {
            deliveryCharge  = parseFloat(data.charge);
            $("#deliveryCharge").text(`Total Delivery Cost: ${$("#deliveryCharge").attr('data-currency') ?? ''} ${deliveryCharge.toFixed(2)} `);
        },
        error: function (xhr, status, error) {
            console.log(xhr, status, error);
            $("#deliveryCharge").text("No Charge Found with this combination.");
        },
    });
}

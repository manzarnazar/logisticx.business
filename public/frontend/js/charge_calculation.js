"use strict";

let charge = 0.0;
let area;
let pickup;
let destination;
let pcID;
let stID;

$(document).ready(function () {

    $('#pickup_area').on('select2:select', function(e) {
        detectArea();
    });


    $('#delivery_area').on('select2:select', function(e) {

        detectArea();
    });


    $('#product_category').on('select2:select', function(e) {


        serviceType();

    });

    $('#service_type').on('select2:select', function(e) {

        // Get the value and text of the clicked li element
        let value = $('#service_type').val();
        let text = this.textContent.trim();

        // Update the select element's value and text
        $("#service_type").val(value).change(); // Change the value
        $(".service_type .styledSelect").text(text); // Change the displayed text

        // Call getCharge() function or perform any other actions as needed
        getCharge();
    });
});

function detectArea() {
    pickup = $("#pickup_area").val();
    destination = $("#delivery_area").val();

    if (!pickup || !destination) {
        area = "outside_city";
        return;
    }

    $.ajax({
        type: "POST",
        url: $("#area").data("url"),
        data: { pickup_id: pickup, destination_id: destination },
        dataType: "json",
        success: (data) => (area = data.area),
        error: (data) => console.log(data),
    }).always(() => {
        serviceType();
    });
}

function serviceType() {
    $("#service_type").empty();
    $(".service_type .options").empty();

    $("#service_type").append("<option></option>");
    $(".service_type .options").append(`<li rel="">Select Service Type</li>`);

    $("#service_type").val(); // Change the value
    $(".service_type .styledSelect").text("Select Service Type"); // Change the displayed text

    pcID = $("#product_category").val();

    console.log(pcID);
    console.log(area);

    if (!pcID || !area) {
        return;
    }

    $("#charge").text("Searching Service Types...");

    $.ajax({
        type: "POST",
        url: $("#service_type").data("url"),
        data: { product_category_id: pcID, area: area },
        dataType: "json",
        success: function (data) {
            $("#charge").text(" ");
            if (data.service_types.length === 0) {
                $("#charge").text("No Service type found.");
            }

            for (const type of data.service_types) {
                let option = `<option value="${type.id}">${type.name}</option>`;
                $("#service_type").append(option);

                let liOption = `<li rel="${type.id}">${type.name}</li>`;
                $(".service_type .options").append(liOption);
            }
        },
        error: function (xhr, status, error) {
            $("#charge").text("No Service type found.");
        },
    }).always(() => getCharge());
}

function getCharge() {

    stID = $("#service_type").val();

    if (!pcID || !stID || !area) {
        // $("#charge").text("Select all Parameter");
        return;
    }

    $("#charge").text("Calculating Charge....");


    $.ajax({
        type: "POST",
        url: $("#charge").data("url"),
        data: { product_category_id: pcID, service_type_id: stID, area: area },
        dataType: "json",
        success: function (data) {
            
            charge = parseFloat(data.charge);
            $("#charge").text(`Total Delivery Cost: ${$("#charge").attr('data-currency') ?? ''} ${charge.toFixed(2)} `);
        },
        error: function (xhr, status, error) {
            console.log(xhr);
            console.log(status);
            console.log(error);
            $("#charge").text("No Charge Found with this combination.");
        },
    });
}

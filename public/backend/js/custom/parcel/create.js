"use strict";

let merchant = {};

const parcel = {
    cashCollection: parseFloat($("#cash_collection").val()),
    codCharge: parseFloat($("#cod_charge").val()),
    fragileLiquidCharge: parseFloat($("#fragileLiquid").data("amount")),
    charge: parseFloat($("#charge").val()),
    discount: parseFloat($("#coupon").data("discount")),
    area: $("#area").val(),
    vat_rate: 0.0,
    vat: 0.0,
    vasCharge: 0.0,
    totalCharge: 0.0,
};

$(document).ready(function () {
    $("#shopID").select2({ placeholder: $("#shopID").data("placeholder") });
    $("#product_category").select2({
        placeholder: $("#product_category").data("placeholder"),
    });
    $("#service_type").select2({
        placeholder: $("#service_type").data("placeholder"),
    });
    $("#destination").select2({
        placeholder: $("#destination").data("placeholder"),
    });
    $("#vas").select2({ placeholder: $("#vas").data("placeholder") });

    $(".hideShowCOD").hide();
    $(".hideShowLiquidFragile").hide();
    $(".hideShowVAS").hide();
    $(".hideShowDiscount").hide();

    $("#parcelForm").submit(submitForm);

    searchMerchant();
    merchantDetails();
    shopDetails();
    cashCollection();
    vasCharge();
    applyCoupon();
    totalSum();
});

$("#merchant_id").on("change", () => merchantDetails());

$("#shopID").on("change", () => shopDetails());

$("#cash_collection").on("input", () => cashCollection());

$("#destination").on("change", () => detectArea());

$("#fragileLiquid").on("click", () => fragileLiquidCharge());

$("#vas").on("change", () => vasCharge());

$("#product_category").on("change", () => serviceType());

$("#service_type").on("change", () => getCharge());

$("#quantity").on("input", () => getCharge());

$("#charge").on("input", () => modifyCharge());

$("#couponApply").on("click", () => applyCoupon());
$("#coupon").on("blur", () => applyCoupon());

// ========================================================= Ajax Calls ================================================

function searchMerchant() {
    const url = $("#merchant_id").data("url");

    $("#merchant_id").select2({
        placeholder: $("#merchant_id").data("placeholder"),
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
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

function merchantDetails() {
    const mid = $("#merchant_id").val();
    const url = $("#merchant_id").data("url");

    if (!mid) {
        console.log("Merchant id not selected.");
        return;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: { search: mid, searchQuery: false },
        dataType: "json",
        success: function (data) {
            merchant = data;
            $("#merchant").val(merchant);
            parcel.merchant_id = merchant.id;
            parcel.vat_rate = merchant.vat;

            console.log(merchant);
            console.log(parcel);

            $("#shopID").empty();
            $("#shopID").append("<option></option>");
            for (const shop of merchant.shops) {
                let option = `<option value="${shop.id}"> ${shop.name}</option>`;
                $("#shopID").append(option);
            }
        },
    }).always(() => shopDetails());
}

function shopDetails() {
    if (!parcel.merchant_id) {
        return;
    }

    if (!merchant.shops) {
        console.error("Shops not found");
        return;
    }
    const shopID = $("#shopID").val();

    if (!shopID) {
        console.error("Shop not selected");
        return;
    }

    parcel.shop = merchant.shops.find((shop) => shop.id == shopID);

    $("#pickup_phone").val(parcel.shop.contact_no);
    $("#pickup_address").val(parcel.shop.address);

    detectArea();
}

function detectArea() {
    if (!parcel.shop) {
        parcel.area = "outside_city";
        return;
    }
    const url = $("#area").data("url");
    let pickup = parcel.shop.coverage_id;
    let destination = $("#destination").val();

    $.ajax({
        type: "POST",
        url: url,
        data: { pickup_id: pickup, destination_id: destination },
        dataType: "json",
        success: (data) => {
            console.log(data);
            parcel.area = data.area;
            $("#area").val(parcel.area);
        },
        error: (data) => console.log(data),
    }).always(() => {
        cashCollection();
        serviceType();
    });
}

function serviceType() {
    $("#service_type").empty();
    const url = $("#service_type").data("url");
    parcel.pcID = $("#product_category").val();

    if (parcel.pcID == "") {
        console.log("Product Category not selected.");
        return;
    }
    if (parcel.area == "") {
        console.log("Area not selected.");
        return;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: { product_category_id: parcel.pcID, area: parcel.area },
        dataType: "json",
        success: function (data) {
            $("#service_type").append("<option></option>");
            for (const type of data.service_types) {
                let option = `<option value="${type.id}"  > ${type.name}</option>`;
                $("#service_type").append(option);
            }
        },
    }).always(() => getCharge());
}

function modifyCharge() {
    parcel.charge = parseFloat($("#charge").val()) || 0;
    console.log(parcel.charge);
    totalSum();
    fragileLiquidCharge();
}

function getCharge() {
    parcel.stID = $("#service_type").val();
    parcel.charge = 0;

    if (parcel.pcID == "") {
        console.log("Product Category not selected.");
        return;
    }
    if (parcel.stID == "") {
        console.log("Service type not selected.");
        return;
    }
    if (parcel.area == "") {
        console.log("Area not selected.");
        return;
    }

    $.ajax({
        type: "POST",
        url: $("#charge").data("url"),
        data: {
            merchant_id: parcel.merchant_id,
            product_category_id: parcel.pcID,
            service_type_id: parcel.stID,
            area: parcel.area,
        },
        dataType: "json",
        success: function (data) {
            const q = parseFloat($("#quantity").val()); // Convert to a floating-point number
            if (isNaN(q) || q < 1) {
                $("#quantity").val(1);
            }
            parcel.charge = parseFloat(data.charge);

            if (!isNaN(q) && q > 1) {
                parcel.charge += (q - 1) * parseFloat(data.additional_charge);
            }

            $("#charge").val(parcel.charge);
        },
        error: $("#charge").val(parcel.charge),
    }).always(() => {
        totalSum();
        fragileLiquidCharge();
    });
}

function cashCollection() {
    parcel.codCharge = 0;
    $(".hideShowCOD").hide();

    parcel.cashCollection = parseFloat($("#cash_collection").val()) || 0;
    $("#totalCashCollection").text(parcel.cashCollection.toFixed(2));

    if (parcel.cashCollection > 0 && merchant.cod_charges && parcel.area) {
        parcel.cod_rate = Number(merchant.cod_charges[parcel.area]);
        parcel.codCharge = (parcel.cod_rate * parcel.cashCollection) / 100;
    }

    if (parcel.codCharge > 0) {
        $(".hideShowCOD").show();
        $("#codAmount").text(parcel.codCharge.toFixed(2));
    }

    totalSum();
}

function fragileLiquidCharge() {
    parcel.fragileLiquidCharge = 0;
    $(".hideShowLiquidFragile").hide();

    if (!merchant.cod_charges) {
        $("#fragileLiquid").prop("checked", false); // uncheck the checkbox
        return;
    }

    if ($("#fragileLiquid").is(":checked")) {
        const parentage = parseFloat(merchant.liquid_fragile_rate) || 0;
        parcel.fragileLiquidCharge = (parentage * parcel.charge) / 100;
        $(".hideShowLiquidFragile").show();
        $("#liquidFragileAmount").text(parcel.fragileLiquidCharge.toFixed(2));
    }

    totalSum();
}

function vasCharge() {
    parcel.vasCharge = 0;
    $(".hideShowVAS").hide();

    var selectedOptions = $("select#vas option:selected");

    selectedOptions.each(function () {
        var amount = parseFloat($(this).data("price"));
        if (!isNaN(amount)) {
            parcel.vasCharge += amount;
        }
    });

    if (parcel.vasCharge > 0) {
        $(".hideShowVAS").show();
        $("#vasAmount").text(parcel.vasCharge.toFixed(2));
    }
    totalSum();
}

function applyCoupon() {
    $(".hideShowDiscount").hide();
    $("#coupon_error_text").addClass("d-none"); // Add the d-none class
    parcel.discount = 0;
    const coupon = $("#coupon").val();

    parcel.totalCharge =
        parcel.charge +
        parcel.codCharge +
        parcel.fragileLiquidCharge +
        parcel.vasCharge;

    if (!coupon || !parcel.merchant_id || !parcel.totalCharge) {
        totalSum();
        return;
    }

    // console.log(parcel.totalCharge, "before apply coupon");

    $.ajax({
        type: "POST",
        url: $("#coupon").data("url"),
        data: {
            coupon: coupon,
            mid: parcel.merchant_id,
            charge: parcel.totalCharge,
        },
        dataType: "json",
        success: function (response) {
            if (response.verify && response.discount > 0) {
                parcel.discount = response.discount;
                $(".hideShowDiscount").show();
                $("#discount").text(parcel.discount.toFixed(2));
                return;
            }

            // Handle an invalid coupon
            $("#coupon_error_text").removeClass("d-none"); // Remove the d-none class
            $("#coupon_error_text").text(response.error);
        },
        error: function (response) {
            $("#coupon_error_text").removeClass("d-none"); // Remove the d-none class
            $("#coupon_error_text").text(
                JSON.parse(response.responseText).message
            );
        },
    }).always(() => totalSum());
}

function totalSum() {
    // console.log(parcel);
    parcel.totalCharge =
        parcel.charge +
        parcel.codCharge +
        parcel.fragileLiquidCharge +
        parcel.vasCharge -
        parcel.discount;

    parcel.vat = parcel.totalCharge * (parcel.vat_rate / 100);

    parcel.totalCharge = parcel.totalCharge + parcel.vat;

    $("#chargeAmount").text(parcel.charge.toFixed(2));

    $("#VatAmount").text(parcel.vat.toFixed(2));

    $("#totalCharge").text(parcel.totalCharge.toFixed(2));

    let currentPayable = parcel.cashCollection - parcel.totalCharge;
    $("#currentPayable").text(currentPayable.toFixed(2));
}

async function submitForm(event) {
    event.preventDefault();

    const form = event.target; // Accessing the form from the event
    const url = form.getAttribute("action"); // get action url
    const formData = new FormData(form); // access form data

    const errorBoxes = form.querySelectorAll(".errorTextBox"); // access all error boxes
    errorBoxes.forEach((elm) => elm.classList.add("d-none")); // hide all error boxes

    const submitBtn = form.querySelector('button[type="submit"]'); // Target submit button
    const buttonText = submitBtn.innerHTML; // Get default button text

    const iconElement = document.createElement("i"); // Create i tag for fa icon

    iconElement.className = "fa fa-spinner fa-spin"; // Add fa icon class to i tag
    submitBtn.textContent = submitBtn.getAttribute("data-loading-text"); // Change the submit button text
    submitBtn.appendChild(iconElement); // Append the icon to the button
    submitBtn.disabled = true; // Disable the submit button

    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData,
            headers: { Accept: "application/json" },
        });

        const data = await response.json();

        if (response.ok && data.status) {
            window.location.href = data.data.redirect_url;
            alertMessage(data.message, "success");
        }

        if (!data.status && data.message) {
            alertMessage(data.message, "error");
        }

        if (data.errors) {
            Object.entries(data.errors).forEach(([key, value]) => {
                let element = form.querySelector(`[name="${key}"]`);
                let errorElm = form.querySelector(`[data-error-for="${key}"]`);
                if (errorElm) {
                    errorElm.textContent = value;
                    errorElm.classList.remove("d-none");
                } else {
                    alertMessage(value, "error");
                }
                if (element) {
                    element.addEventListener("change", function () {
                        errorElm ? errorElm.classList.add("d-none") : "";
                    });
                }
            });
        }
    } catch (error) {
        // console.log(error);
        // alertMessage("Something went wrong, pls try again later", "error");
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = buttonText;
    }
}

function alertMessage(message, icon = "error") {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: icon,
        title: message,
    });
}

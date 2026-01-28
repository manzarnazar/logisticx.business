"use strict";

let parcel_id = null;

$(document).ready(function () {
    $(".send_otp_btn").on("click", sendOtp);
    $("#deliveryForm").submit(submitForm);
    $("#partial_deliveredForm").submit(submitForm);
});

function setParcelId(parcelId, selector) {
    const element = document.querySelector(selector);
    element.setAttribute("value", parcelId);
    parcel_id = parcelId;
    console.log(parcel_id);
}

function sendOtp() {
    const buttonText = $(this).text();
    $(this).html(`<i class="fa fa-spinner fa-spin"></i> Processing...`);
    $(this).prop("disabled", true);

    $.ajax({
        url: $(this).data("url"),
        method: "POST",
        dataType: "json",
        data: {
            parcel_id: parcel_id,
            status: $(this).data("status"),
        },
        success: function (response) {
            if (response.status && response.message) {
                alertMessage(response.message, "success");
            } else {
                alertMessage(response.message, "error");
            }
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
        complete: () => {
            $(this).html(buttonText);
            $(this).prop("disabled", false);
        },
    });
}

async function submitForm(event) {
    event.preventDefault();

    const form               = event.target;                                 // Accessing the form from the event
    const url                = form.getAttribute("action");                  // get action url
    const formData           = new FormData(form);                           // access form data

    const errorBoxes         = form.querySelectorAll(".errorTextBox");       // access all error boxes
    errorBoxes.forEach((elm) => elm.classList.add("d-none"));                // hide all error boxes

    const submitBtn          = form.querySelector('button[type ="submit"]'); // Target submit button
    const buttonText         = submitBtn.textContent;                        // Get default button text

    const iconElement        = document.createElement("i");                  // Create i tag for fa icon

    iconElement.className    = "fa fa-spinner fa-spin";                      // Add fa icon class to i tag
    submitBtn.textContent    = "Processing... ";                             // Change the submit button text
    submitBtn.appendChild(iconElement);                                      // Append the icon to the button
    submitBtn.disabled       = true;                                         // Disable the submit button

    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData,
            headers: { Accept: "application/json" },
        });

        const data = await response.json();

        if (response.ok && data.status) {
            alertMessage(data.message, "success");
            window.location.href = data.data.redirect_url;
            return;
        }

        if (!data.status && data.message) {
            alertMessage(data.message, "error");
        }

        if (data.data.errors) {
            Object.entries(data.data.errors).forEach(([key, value]) => {
                let element  = form.querySelector(`[name="${key}"]`);
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
        console.log(error);
        alertMessage("Something went wrong, pls try again later", "error");
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = buttonText;
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

function pleaseConfirm(event) {
    event.preventDefault(); // Prevent the default behavior of the link
    const element  = event.target;
    const url      = element.getAttribute("href");
    const title    = element.textContent;
    const question = element.getAttribute("data-question") || "Are you sure?";

    Swal.fire({
        title: title,
        text: question,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Confirm",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Redirect to the URL
        }
    });
}

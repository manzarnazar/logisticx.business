"use strict";

$(document).ready(function () {
    $("#isprocess").on("change", isProcess);
    $("#hub_id").on("change", hubAccounts);

    $("#hubPaymentForm").submit(submitForm);

    isProcess();
    // hubAccounts();

    searchAccount();
});

function isProcess() {
    $(".process").addClass("d-none");
    $(".process").prop("disabled", true);

    if ($("#isprocess").is(":checked")) {
        $(".process").removeClass("d-none");
        $(".process").prop("disabled", false);
        searchAccount();
    }
}

function hubAccounts() {
    $("#hub_account_id").empty();

    const url = $("#hub_account_id").data("url");

    $("#hub_account_id").select2({
        placeholder: "Select Hub Account",
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                const hub_id = $("#hub_id").val();
                return {
                    select2: true,
                    search: params.term,
                    hub_id: hub_id,
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

function searchAccount() {
    const url = $("#from_account").data("url");

    $("#from_account").select2({
        placeholder: "Select account",
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                const account_id = $("#hub_account_id").val() ?? null;
                // const hub_id = $("#hub_id").val() ?? null;
                // const user_id = $("#from_account").data("user-id");
                return {
                    select2: true,
                    search: params.term,
                    except_account_id: account_id,
                    // except_hub_id: hub_id,
                    // user_id: user_id,
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

async function submitForm(event) {
    event.preventDefault();

    const form = event.target; // Accessing the form from the event
    const url = form.getAttribute("action"); // get action url
    const formData = new FormData(form); // access form data

    const errorBoxes = form.querySelectorAll(".errorTextBox"); // access all error boxes
    errorBoxes.forEach((elm) => elm.classList.add("d-none")); // hide all error boxes

    const submitBtn = form.querySelector('button[type="submit"]'); // Target submit button
    const buttonText = submitBtn.textContent; // Get default button text

    const iconElement = document.createElement("i"); // Create i tag for fa icon

    iconElement.className = "fa fa-spinner fa-spin"; // Add fa icon class to i tag
    submitBtn.textContent = "Processing... "; // Change the submit button text
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

    const element = event.target;
    const url = element.getAttribute("href");
    const title = element.textContent;
    const question = element.getAttribute("data-question") || "Are you sure?";

    Swal.fire({
        title: title,
        text: question,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FF0303",
        confirmButtonText: "Confirm",
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = url; // Redirect to the URL
        }
    });
}

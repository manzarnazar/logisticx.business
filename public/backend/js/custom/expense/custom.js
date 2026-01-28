"use strict";

let clearRows = false; // keep false for edit page

$(document).ready(function () {
    $("#expenseForm").submit(submitForm);
    $("#account_head_id").on("change", applyAccountHead);
    $("#delivery_man_id").on("change", getHeroCommissions);
    $("#hub_id").on("change", hubAccounts);

    $(document).on("change", ".parcels", updateTotalAmount);

    $("#allCheckBox").on("change", function () {
        var isChecked = $(this).prop("checked");
        $(".parcels").prop("checked", isChecked);
        updateTotalAmount();
    });

    applyAccountHead();
    searchAccount();
    getHeroCommissions();
});

function applyAccountHead() {
    // hide conditional inputs
    $(".inputs-delivery-man").addClass("d-none");
    $(".inputs-hub").addClass("d-none");
    $(".inputs-other").addClass("d-none");

    $(".inputs-delivery-man").prop("disabled", true);
    $(".inputs-hub").prop("disabled", true);
    $(".inputs-other").prop("disabled", true);

    $("#amount").prop("readonly", false);

    // clearRows ? $("#parcelList").empty() : "";

    const headID = $("#account_head_id").val();

    if (headID == payHero) {
        searchDeliveryMan();
    } else if (headID == payHub) {
        $(".inputs-hub").removeClass("d-none");
        $(".inputs-hub").prop("disabled", false);
    } else {
        $(".inputs-other").removeClass("d-none");
        $(".inputs-other").prop("disabled", false);
    }
}

function searchDeliveryMan() {
    $("#amount").prop("readonly", true);
    $(".inputs-delivery-man").removeClass("d-none");
    $(".inputs-delivery-man").prop("disabled", false);

    const url = $("#delivery_man_id").data("url");

    $("#delivery_man_id").select2({
        placeholder: "Select Delivery man",
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                $("#delivery_man_id").empty();
                clearRows = true;
                return {
                    name: params.term,
                    select2: true,
                    // search: params.term,
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
    const url = $("#account_id").data("url");

    $("#account_id").select2({
        placeholder: "Select account",
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                // const user_id = $("#account_id").data("user-id");
                const headID = $("#account_head_id").val();
                let hub_id = null;
                if (headID == payHub) {
                    hub_id = $("#hub_id").val() ?? null;
                }
                return {
                    select2: true,
                    search: params.term,
                    except_hub_id: hub_id,
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

function hubAccounts() {
    $("#hub_account_id").empty();

    const url = $("#account_id").data("url");

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

function getHeroCommissions() {
    const url = $("#parcelList").data("url");
    const delivery_man_id = $("#delivery_man_id").val();

    if (!delivery_man_id) {
        return;
    }
    $.ajax({
        type: "post",
        url: url,
        data: { delivery_man_id: delivery_man_id },
        dataType: "json",
        success: function (commissions) {
            console.table(commissions);
            $("#parcelTableBox").removeClass("d-none");

            clearRows ? $("#parcelList").empty() : (clearRows = true);

            $.each(commissions, function (index, commission) {
                // Format the date using JavaScript
                const serverDate = new Date(commission.updated_at);
                const show = { month: "long", day: "numeric", year: "numeric" };
                const date = serverDate.toLocaleString("en-US", show);

                let row = `<tr>
                                <td> <input type='checkbox' id='parcel_${commission.parcel_id}' class="parcels" value='${commission.parcel_id}' name='parcel_id[]' data-commission="${commission.amount}" /> </td>
                                <td><label for="parcel_${commission.parcel_id}"> ${commission.parcel.tracking_id} </label></td> 
                                <td>${commission.amount}</td>
                                <td>${date}</td> 

                            </tr>`;

                $("#parcelList").append(row);
            });
        },
        error: (data) => {
            if (clearRows) {
                alertMessage(data.responseJSON.message, "error");
                $("#parcelTableBox").addClass("d-none");
            } else {
                clearRows = true;
            }
        },
    }).always(() => updateTotalAmount());
}

function updateTotalAmount() {
    var allChecked = $(".parcels:checked").length === $(".parcels").length;
    $("#allCheckBox").prop("checked", allChecked);

    let total = 0;

    $(".parcels:checked").each(function () {
        total += parseFloat($(this).data("commission")) ?? 0;
    });
    $("#amount").val(total.toFixed(2));
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

    Toast.fire({ icon: icon, title: message });
}

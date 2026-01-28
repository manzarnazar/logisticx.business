"use strict";

let clearRows = false; // keep false for edit page

$(document).ready(function () {
    $("#incomeForm").submit(submitForm);
    $("#account_head_id").on("change", applyAccountHead);
    $("#delivery_man_id").on("change", getParcels);
    $("#merchant_id").on("change", getParcels);

    $("#hub_id").on("change", () => {
        hubAccounts();
        if ($("#account_head_id").val() == fromHub) {
            getParcels();
        }
    });

    $(document).on("change", ".parcels", updateTotalAmount);

    $("#allCheckBox").on("change", function () {
        var isChecked = $(this).prop("checked");
        $(".parcels").prop("checked", isChecked);
        updateTotalAmount();
    });

    applyAccountHead();
    getParcels();
});

function applyAccountHead() {
    // hide conditional inputs
    $(".inputs-delivery-man").addClass("d-none");
    $(".inputs-hub").addClass("d-none");
    $(".inputs-merchant").addClass("d-none");
    $(".inputs-other").addClass("d-none");

    $(".inputs-delivery-man").prop("disabled", true);
    $(".inputs-hub").prop("disabled", true);
    $(".inputs-merchant").prop("disabled", true);
    $(".inputs-other").prop("disabled", true);
    $("#amount").prop("readonly", true);

    clearRows ? $("#parcelList").empty() : "";

    const headID = $("#account_head_id").val();

    if (headID == fromDeliveryMan) {
        $(".inputs-delivery-man").removeClass("d-none");
        $(".inputs-delivery-man").prop("disabled", false);
        searchDeliveryMan();
    } else if (headID == fromHub) {
        $(".inputs-hub").removeClass("d-none");
        $(".inputs-hub").prop("disabled", false);
        searchAccount();
    } else if (headID == fromMerchant) {
        $(".inputs-merchant").removeClass("d-none");
        $(".inputs-merchant").prop("disabled", false);
        searchMerchant();
        searchAccount();
    } else {
        $(".inputs-other").removeClass("d-none");
        $(".inputs-other").prop("disabled", false);
        $("#amount").prop("readonly", false);
        searchAccount();
    }
}

function searchDeliveryMan() {
    const url = $("#delivery_man_id").data("url");

    $("#delivery_man_id").select2({
        placeholder: "Select Delivery man",
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                const hub_id = $("#hub_id").val();
                return {
                    name: params.term,
                    hub_id: hub_id,
                    select2: true,
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

function searchMerchant() {
    const url = $("#merchant_id").data("url");

    $("#merchant_id").select2({
        placeholder: "Select merchant",
        ajax: {
            url: url,
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
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
                const headID = $("#account_head_id").val();
                let hub_id = null;
                if (headID == fromHub) {
                    hub_id = $("#hub_id").val() ?? null;
                }

                return {
                    search: params.term,
                    select2: true,
                    except_hub_id: hub_id,
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
    const hub_id = $("#hub_id").val();
    const url = $("#hub_account_id").data("url");
    $.ajax({
        type: "post",
        url: url,
        data: { hub_id: hub_id, select2: true },
        dataType: "json",
        success: function (accounts) {
            $("#hub_account_id").append("<option></option>");
            for (const account of accounts) {
                let option = `<option value="${account.id}"> ${account.text}</option>`;
                $("#hub_account_id").append(option);
            }
        },
    });
}

function getParcels() {
    const headID = $("#account_head_id").val();

    let data = {};
    let url;

    if (headID == fromDeliveryMan) {
        data.delivery_man_id = $("#delivery_man_id").val();
        url = $("#delivery_man_id").data("parcel-url");
    }
    if (headID == fromHub) {
        data.hub_id = $("#hub_id").val();
        url = $("#hub_id").data("parcel-url");
    }
    if (headID == fromMerchant) {
        data.merchant_id = $("#merchant_id").val();
        url = $("#merchant_id").data("parcel-url");
    }

    if (!url) {
        clearRows ? $("#parcelList").empty() : (clearRows = true);
        return;
    }

    $("#parcelTableBox").removeClass("d-none");

    $.ajax({
        type: "post",
        url: url,
        data: data,
        dataType: "json",
        success: function (parcels) {
            clearRows ? $("#parcelList").empty() : (clearRows = true);

            $.each(parcels, function (index, parcel) {
                let row = `<tr>
                                <td> <input type='checkbox' id='parcel_${parcel.id}' class="parcels" value='${parcel.id}' name='parcel_id[]' data-cod="${parcel.parcel_transaction.cash_collection}" data-charge="${parcel.parcel_transaction.total_charge}"   /> </td>
                                <td><label for="parcel_${parcel.id}"> ${parcel.tracking_id} </label></td>
                                <td>${parcel.parcel_transaction.cash_collection}</td>
                                <td>${parcel.parcel_transaction.total_charge}</td>
                                <td>${parcel.delivery_date}</td>
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
        const headID = $("#account_head_id").val();
        let amount = 0;
        if (headID == fromMerchant) {
            amount = parseFloat($(this).data("charge")) ?? 0;
        } else {
            amount = parseFloat($(this).data("cod")) ?? 0;
        }
        total += amount;
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

    Toast.fire({
        icon: icon,
        title: message,
    });
}

// function getAccountBalance(account_id) {
//     const url = $("#account_head_id").val("account-balance-url");
//     const balance = 0;
//     $.ajax({
//         type: "post",
//         url: url,
//         data: { search: account_id },
//         success: function (data) {
//             balance = parseInt(data.balance);
//         },
//     });
//     return balance;
// }

"use strict";

$(document).ready(function () {
    $("#merchant").select2({
        ajax: {
            url: $("#merchant").data("url"),
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

    $(document).on("change", "#merchant", function () {
        getParcels();
        getAccounts();
    });

    $(document).on("change", ".parcels", updateTotalCashCollection);

    $("#allCheckBox").on("change", function () {
        var isChecked = $(this).prop("checked");
        $(".parcels").prop("checked", isChecked);
        updateTotalCashCollection();
    });

    $("#isprocess").on("change", isProcess);

    isProcess();
    // getAccounts();
    // getParcels();
});

function isProcess() {
    if ($("#isprocess").is(":checked")) {
        $(".process").show();
    } else {
        $(".process").hide();
    }
}

function getAccounts() {
    var merchant = $("#merchant").val();
    $.ajax({
        type: "POST",
        url: $("#merchant_account").data("url"),
        data: { merchant_id: merchant },
        dataType: "json", // Change to expect JSON response
        success: function (accounts) {
            // Update accounts dropdown
            $("#merchant_account").html(accounts);
        },
    });
}

function getParcels() {
    var merchant = $("#merchant").val();
    $("#parcelTableBox").removeClass("d-none");
    $.ajax({
        type: "POST",
        url: $("#parcelList").data("url"),
        data: { merchant_id: merchant },
        dataType: "json",
        success: function (parcels) {
            $("#parcelList").empty();
            // Start building the table rows
            $.each(parcels, function (index, parcel) {
                let row = `<tr>
                                <td> <input type='checkbox' id='parcel_${parcel.id}' class="parcels" value='${parcel.id}' name='parcel_id[]' data-cod="${parcel.parcel_transaction.cash_collection}" data-charge="${parcel.parcel_transaction.total_charge}" /> </td>
                                <td> <label for="parcel_${parcel.id}"> ${parcel.tracking_id} </label> </td>
                                <td>${parcel.parcel_transaction.cash_collection}</td>
                                <td>${parcel.parcel_transaction.total_charge}</td>
                                <td>${parcel.delivery_date}</td>
                            </tr>`;
                $("#parcelList").append(row);
            });
        },
        error: (data) => {
            alertMessage(data.responseJSON.message, "error");
            $("#parcelTableBox").addClass("d-none");
        },
    }).always(() => updateTotalCashCollection());
}

function updateTotalCashCollection() {
    let total_cod = 0;
    let total_charge = 0;
    let total_payable = 0;

    $(".parcels:checked").each(function () {
        let cod = parseFloat($(this).data("cod")) ?? 0;
        let charge = parseFloat($(this).data("charge")) ?? 0;

        total_cod += cod;
        total_charge += charge;

        if (total_cod >= total_charge) {
            total_payable = total_cod - total_charge;
        } else {
            total_cod -= cod;
            total_charge -= charge;
            $(this).prop("checked", false);
        }
    });

    $("#amount").val(total_payable.toFixed(2));
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

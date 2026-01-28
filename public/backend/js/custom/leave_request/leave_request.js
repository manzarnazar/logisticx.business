"use strict";

$(document).ready(function () {
    $("#userID").select2({
        placeholder: $("#userID").data("placeholder"),
        allowClear: true,
        ajax: {
            url: $("#userID").data("url"),
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

    $("#userID").change(getLeaveTypes);
});

function getLeaveTypes() {
    let url = $("#type_id").data("url");
    let user = $("#userID").val();

    // Check for empty values or null
    if (user == null || !url) {
        return null;
    }

    $.ajax({
        type: "post",
        url: url,
        data: { user_id: user },
        dataType: "json",
        success: function (types) {
            $("#type_id").empty(); // Clear existing options

            types.forEach((type) => {
                let option = document.createElement("option");
                option.value = type.id;
                option.innerHTML = `${type.name} ( ${type.remaining_days}) `;
                $("#type_id").append(option);
            });
        },
        error: function (xhr) {
            if (xhr.responseText) {
                try {
                    var data = JSON.parse(xhr.responseText);
                    $("#type_id").html(
                        `<option disabled selected value="0">${data.message}</option>`
                    );
                } catch (error) {
                    console.error("Error parsing JSON response:", error);
                }
            } else {
                $("#type_id").html(
                    `<option disabled selected value="0">An error occurred</option>`
                );
            }
        },
    });
}

function leaveIdPassAndAvailableLeaveDays(modal, id, type_id) {
    $(modal).val(id);

    fetchAvailableLeaveDays(id, type_id);
}

function fetchAvailableLeaveDays(id, type_id) {
    $.ajax({
        url: `/admin/leave/all-leave-request/available-days/${id}/${type_id}`,
        method: "GET",
        data: { id: id, typeId: type_id },
        success: function (response) {
            console.log(response);
            $(".availableDays").text(response);
        },
        error: function (xhr, status, error) {
            console.error(error);
        },
    });
}

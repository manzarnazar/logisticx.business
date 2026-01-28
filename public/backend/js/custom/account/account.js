"use strict";

// Account -> When gateway select then show different input field
// start

// when cash
$("#balance").hide();
// when bank
$("#account_holder_name").hide();
$("#account_no").hide();
$("#bank").hide();
$("#branch_name").hide();
$("#opening_balance").hide();
// when bkash,rocket,nagad
// - also account holder name
$("#mobile").hide();
$("#account_type").hide();
// - opening balance

$("#accountStatus").hide();
$("#gateway").on("change", function () {
    if ($(this).val() !== null) {
        $("#accountStatus").show();
    } else {
        $("#accountStatus").hide();
    }
});

if ($("#gateway").val() == 1) {
    //show
    $("#balance").show();
} else if ($("#gateway").val() == 2) {
    //show
    $("#account_holder_name").show();
    $("#account_no").show();
    $("#bank").show();
    $("#branch_name").show();
    $("#opening_balance").show();
} else if (
    $("#gateway").val() == 3 ||
    $("#gateway").val() == 4 ||
    $("#gateway").val() == 5
) {
    //show
    $("#account_holder_name").show();
    $("#mobile").show();
    $("#account_type").show();
    $("#opening_balance").show();
}

$("#gateway").on("change", function () {
    if ($("#gateway").val() == 1) {
        //show

        $("#balance").show();
        //hide
        $("#account_holder_name").hide();
        $("#account_no").hide();
        $("#bank").hide();
        $("#branch_name").hide();
        $("#opening_balance").hide();
        $("#mobile").hide();
        $("#account_type").hide();
    } else if ($("#gateway").val() == 2) {
        //show
        $("#account_holder_name").show();
        $("#account_no").show();
        $("#bank").show();
        $("#branch_name").show();
        $("#opening_balance").show();
        //hide
        $("#balance").hide();
        $("#mobile").hide();
        $("#account_type").hide();
    } else if (
        $("#gateway").val() == 3 ||
        $("#gateway").val() == 4 ||
        $("#gateway").val() == 5
    ) {
        //show
        $("#account_holder_name").show();
        $("#mobile").show();
        $("#account_type").show();
        $("#opening_balance").show();
        //hide
        $("#balance").hide();
        $("#account_no").hide();
        $("#bank").hide();
        $("#branch_name").hide();
    }
});
// end

$(document).ready(function () {
    $("#gateway").on("change", function () {
        var gateway = $(this).val();
        if (gateway == 1) {
            $("#userRequired").text("*");
        } else {
            $("#userRequired").text("");
        }
    });

    $("#hub").on("change", getUsers);
});

function getUsers() {
    $("#userID").prop("disabled", true);
    const hub_id = $("#hub").val();
    const url = $("#userID").data("url");
    $.ajax({
        type: "POST",
        url: url,
        data: { hub_id: hub_id },
        dataType: "json",
        success: function (data) {
            $("#userID").prop("disabled", false);
            $("#userID").empty();
            $("#userID").append("<option></option>");
            for (const user of data.users) {
                let option = `<option value="${user.id}">${user.name}</option>`;
                $("#userID").append(option);
            }
        },
    });
}

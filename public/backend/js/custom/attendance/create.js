"use strict";
$(document).ready(function () {
    $("#userID").select2({
        placeholder: $("#userID").attr("data-placeholder"),
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

    $("#department, #designation, #userID, #date").change(getUsers);

    getUsers();
});

function getUsers() {
    const url = $("#user_rows").data("url");

    const department = $("#department").val();
    const designation = $("#designation").val();
    const user = $("#userID").val();
    const date = $("#date").val();

    // Check for empty values or null
    if (department == 0 && designation == 0 && (user == 0 || user == null)) {
        // console.log("All values are empty or null. Exiting function.");
        $("#user_rows").html(" ");
        $(".j-create-btns").addClass("d-none");
        return null;
    }

    $.ajax({
        type: "POST",
        url: url,
        data: {
            department_id: department,
            designation_id: designation,
            user_id: user,
            date: date,
        },
        dataType: "json",
        success: function (data) {
            $("#user_rows").html(data);
            $(".j-create-btns").removeClass("d-none");

            // Initialize Flatpickr on input[type="time"]
            $('input[type="time"]').flatpickr({
                enableTime: true,
                noCalendar: true,
                dateFormat: "H:i:S",
                altInput: true,
                altFormat: "h:i K",
            });
        },
        error: function (xhr) {
            $("#user_rows").html(" ");
            $(".j-create-btns").addClass("d-none");
            if (xhr.responseText) {
                try {
                    let data = JSON.parse(xhr.responseText);
                    if (typeof alertMessage === "function") {
                        alertMessage(data.error, "error");
                    }
                    console.log("Error:", data.error);
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                }
            }
        },
    });
}

"use strict";
$(document).ready(function () {
    // search user
    $("#user_id").select2({
        ajax: {
            url: $("#user_id").data("url"),
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

    $("#user_id").change(getSalary);

    // this searchAccount function need in pay.blade.php
    searchAccount();
});

function getSalary() {
    let uid = $("#user_id").val();
    let url = $("#basic_salary").data("url");

    // Check for empty values or null
    if (!url || !uid) {
        return null;
    }
    console.log(uid);
    console.log(url);

    $.ajax({
        type: "POST",
        url: url,
        data: { user_id: uid },
        dataType: "json",
        success: function (data) {
            $("#basic_salary").val(data.basic_salary);
        },
        error: function (xhr) {
            $("#basic_salary").val(0);

            if (xhr.responseText) {
                console.log(xhr.responseText);
                try {
                    let data = JSON.parse(xhr.responseText);
                    console.log("Error:", data.message);
                } catch (e) {
                    console.error("Error parsing JSON response:", e);
                }
            }
        },
    });
}

function addAllowance() {
    var container = document.getElementById("allowance-container");
    var row = container.childElementCount + 1;

    var newRow = document.createElement("div");
    newRow.className = "row";
    newRow.innerHTML = `
        <div class="col-7">
            <input type="text" name="allowance[${row}][name]" class="form-control input-style-1" placeholder="Enter allowance name">
        </div>
        <div class="col-5">
            <div class="input-group mb-3">
                <input type="number" step="any" name="allowance[${row}][amount]" class="form-control input-style-1" placeholder="Enter amount">
                <span class="input-group-text btn btn-danger ml-1 p-0" onclick="deleteRow(this)"> <i class="fa-solid fa-trash"></i> </span>
            </div>
        </div>
    `;

    container.appendChild(newRow);
}

function addDeduction() {
    var container = document.getElementById("deduction-container");

    var row = container.childElementCount + 1;

    var newRow = document.createElement("div");

    newRow.className = "row";
    newRow.innerHTML = `
        <div class="col-7">
            <input type="text" name="deduction[${row}][name]" class="form-control input-style-1" placeholder="Enter Deduction name">
        </div>
        <div class="col-5">
            <div class="input-group mb-3">
                <input type="number" step="any" name="deduction[${row}][amount]" class="form-control input-style-1" placeholder="Enter amount">
                <span class="input-group-text btn btn-danger ml-1 p-0" onclick="deleteRow(this)"> <i class="fa-solid fa-trash"></i> </span>
            </div>
        </div>
    `;

    container.appendChild(newRow);
}

function deleteRow(element) {
    element.closest(".row").remove();
}

function searchAccount() {
    $("#account_id").select2({
        placeholder: $("#account_id").data("placeholder"),
        ajax: {
            url: $("#account_id").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                // const user_id = $("#account_id").data("user-id");
                return {
                    select2: true,
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

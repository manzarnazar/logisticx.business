"use strict";
$("#exportTable").click(function () {
    var title = $(this).data("title");
    var filename = $(this).data("filename");
    $(".table").table2excel({
        name: title,
        filename: filename + ".xlsx", // do include extension
        preserveColors: true, // set to true if you want background colors and font colors preserved
    });
});

// using in leave ,attendance , salary report filter 'user'
$(document).ready(function () {
    // search user
    $("#user_id").select2({
        placeholder: $("#user_id").data("placeholder"),
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
});

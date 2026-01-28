"use strict";
$(document).ready(function () {
    applyFields();
    $("#user_type").on("change", applyFields);
});

function applyFields() {
    const type = $("#user_type").val();
    const hub = $("#user_type").data("hub");
    const hero = $("#user_type").data("hero");
    const merchant = $("#user_type").data("merchant");

    // Hide all elements initially
    $(".merchant, .hub, .hero").addClass("d-none");

    if (type == merchant) {
        $(".merchant").removeClass("d-none");
        searchMerchant();
    }

    if (type == hub) {
        $(".hub").removeClass("d-none");
        searchHub();
    }

    if (type == hero) {
        $(".hero").removeClass("d-none");
        searchHero();
    }
}

function searchMerchant() {
    $("#merchant_id").select2({
        ajax: {
            url: $("#merchant_id").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    searchQuery: true,
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

function searchHub() {
    $("#hub_id").select2({
        ajax: {
            url: $("#hub_id").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    searchQuery: true,
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

function searchHero() {
    $("#delivery_man_id").select2({
        ajax: {
            url: $("#delivery_man_id").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                return {
                    search: params.term,
                    searchQuery: true,
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

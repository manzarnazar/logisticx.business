"use strict";

$(document).ready(function () {
    parcel30DayStatus();
    cod7day();
    // ==========
    // weeklyCodDonut();
});

function weeklyCodDonut() {
    const element = $("#cod_donut");
    const hub = parseFloat(element.data("hub"));
    const admin = parseFloat(element.data("admin"));
    const pending = parseFloat(element.data("pending"));

    Morris.Donut({
        element: "cod_donut",
        data: [
            { label: "Hub", value: hub },
            { label: "Admin", value: admin },
            { label: "Pending", value: pending },
        ],
        resize: true,
        colors: ["#0d6efd", "#0CAF60", "#FF3B3B"],
    });
}

// ===================================================

function parcel30DayStatus() {
    const element = $("#line_chart_2");
    const url = element.data("url");
    const hub_id = element.data("hub");

    $.ajax({
        type: "post",
        url: url,
        data: { hub_id: hub_id },
        dataType: "json",
        success: function (data) {
            // console.table(data);

            let config = {
                element: "line_chart_2",
                data: data,

                xkey: "day",
                ykeys: [
                    "pending",
                    "delivered",
                    "partial_delivered",
                    "returned",
                ],
                labels: [
                    "Pending",
                    "Delivered",
                    "Partial Delivered",
                    "Returned",
                ],

                pointSize: 3,
                fillOpacity: 0.5,
                behaveLikeLine: true,
                gridLineColor: "transparent",
                lineWidth: 3,
                hideHover: "auto",
                lineColors: ["#3887BE", "#65B741", "#65B741", "#D83F31"],
                pointStrokeColors: ["#3887BE", "#65B741", "#65B741", "#D83F31"],
                resize: true,
                parseTime: false,
                pointFillColors: ["#FFE7C1"],
            };

            Morris.Area(config);
        },
    });
}

function cod7day() {
    const element = $("#morris_bar");
    const url = element.data("url");
    const hub_id = element.data("hub");

    $.ajax({
        type: "post",
        url: url,
        data: { hub_id: hub_id },
        dataType: "json",
        success: function (data) {
            // console.table(data);

            let config = {
                element: "morris_bar",
                data: data,
                xkey: "day",
                ykeys: ["pending", "receivedByHub", "receivedByAdmin"],
                labels: ["Pending", "Received By Hub", "Received By Admin"],
                barColors: ["#06C270", "#0D6EFD"],
                hideHover: "auto",
                gridLineColor: "transparent",
                resize: true,
                barSizeRatio: 0.25,
            };

            Morris.Bar(config);
        },
    });
}

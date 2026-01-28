"use strict";

$(document).ready(function () {
    parcel30DayStatus();
    dailyMerchantCharge();
    cod7Day();

    weeklyTotalCodDonut();
    weeklyTotalChargeDonut();
});

function weeklyTotalCodDonut() {
    const element = $("#morris_donut_cod");
    const pending = Number(element.data("pending"));
    const received = Number(element.data("received"));
    const total = pending + received;

    Morris.Donut({
        element: "morris_donut_cod",
        data: [
            { label: "Cash on Delivery", value: total },
            { label: "received", value: received },
            { label: "Pending", value: pending },
        ],
        resize: true,
        colors: ["#0d6efd", "#0CAF60", "#FF3B3B"],
    });
}

function weeklyTotalChargeDonut() {
    const element = $("#morris_donut_charge");
    const paid = Number(element.data("paid"));
    const unpaid = Number(element.data("unpaid"));
    const total = (paid + unpaid).toFixed(2);

    Morris.Donut({
        element: "morris_donut_charge",
        data: [
            { label: "Paid", value: paid },
            { label: "Unpaid", value: unpaid },
            { label: "Total", value: total },
        ],
        resize: true,
        colors: ["#0CAF60", "#FF3B3B", "#0d6efd"],
    });
}

function dailyMerchantCharge() {
    const element = $("#morris_bar");
    const url = element.data("url");

    $.ajax({
        type: "post",
        url: url,
        data: {},
        dataType: "json",
        success: function (data) {
            // console.table(data);

            let config = {
                element: "morris_bar",
                data: data,
                xkey: "day",
                ykeys: ["paid", "unpaid"],
                labels: ["Total paid", "Total unpaid"],

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

function parcel30DayStatus() {
    const element = $("#line_chart_2");
    const url = element.data("url");

    $.ajax({
        type: "post",
        url: url,
        data: {},
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
                    // "in_transit",
                ],
                labels: [
                    "Pending",
                    "Delivered",
                    "Partial Delivered",
                    "Returned",
                    // "Tn Transit",
                ],

                pointSize: 3,
                fillOpacity: 0.5,
                pointFillColors: ["#FFE7C1"],
                behaveLikeLine: true,
                gridLineColor: "transparent",
                lineWidth: 3,
                hideHover: "auto",
                lineColors: ["#3887BE", "#65B741", "#65B741", "#D83F31"],
                pointStrokeColors: ["#3887BE", "#65B741", "#65B741", "#D83F31"],
                resize: true,
                parseTime: false,
            };

            Morris.Area(config);
        },
    });
}

function cod7Day() {
    const element = $("#line_chart_1");
    const url = element.data("url");

    $.ajax({
        type: "post",
        url: url,
        data: {},
        dataType: "json",
        success: function (data) {
            // console.table(data);
            let config = {
                element: "line_chart_1",
                data: data.reverse(),
                xkey: "day",
                ykeys: ["paid", "unpaid"],
                labels: ["Total paid", "Total unpaid"],

                fillOpacity: 0.6,
                hideHover: "auto",
                behaveLikeLine: true,
                resize: true,
                pointFillColors: ["#ffffff"],
                pointStrokeColors: ["black"],
                lineColors: ["green", "red"],
                parseTime: false,
            };

            Morris.Line(config);
        },
    });
}

// function dailyCod() {
//     const element = $("#line_chart_1");
//     const url = element.data("url");

//     $.ajax({
//         type: "post",
//         url: url,
//         data: {},
//         dataType: "json",
//         success: function (data) {
//             console.table(data);

//             let config = {
//                 element: "line_chart_1",
//                 data: data,
//                 xkey: "day",
//                 ykeys: ["paid", "unpaid"],
//                 labels: ["Total paid", "Total unpaid"],

//                 barColors: ["#06C270", "#0D6EFD"],
//                 hideHover: "auto",
//                 gridLineColor: "transparent",
//                 resize: true,
//                 barSizeRatio: 0.25,
//             };

//             Morris.Bar(config);
//         },
//     });
// }

// Morris.Line({
//     element: "line_chart_1",
//     data: [
//         {
//             period: "01",
//             smartphone: 0,
//             windows: 0,
//             mac: 0,
//         },
//         {
//             period: "02",
//             smartphone: 90,
//             windows: 60,
//             mac: 25,
//         },
//         {
//             period: "03",
//             smartphone: 40,
//             windows: 80,
//             mac: 35,
//         },
//     ],
//     xkey: "period",
//     ykeys: ["smartphone", "windows", "mac"],
//     labels: ["Phone", "Windows", "Mac"],
//     fillOpacity: 0.6,
//     hideHover: "auto",
//     behaveLikeLine: true,
//     resize: true,
//     pointFillColors: ["#ffffff"],
//     pointStrokeColors: ["black"],
//     lineColors: ["green", "red"],
//     parseTime: false,
// });

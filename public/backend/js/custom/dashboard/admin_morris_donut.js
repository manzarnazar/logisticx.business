"use strict";

$(document).ready(function () {
    parcel30DayStatus();
    dailyCourierRevenue();
    // ==========
    weeklyCommissionChart();
    // weeklyChargeDonut();
    dailyMerchantCharge();
    weeklyCodDonut();
});

function weeklyCommissionChart() {
    let element = $("#hero_commission_donut");
    const paid = parseFloat(element.data("paid"));
    const unpaid = parseFloat(element.data("unpaid"));
    const total = (paid + unpaid).toFixed(2);

    Morris.Donut({
        element: "hero_commission_donut",
        data: [
            { label: "Paid", value: paid },
            { label: "Total Commission", value: total },
            { label: "Unpaid", value: unpaid },
        ],
        resize: true,
        colors: ["#FFA500", "#adb5bd", "#FF3B3B"],
    });
}

function weeklyChargeDonut() {
    let element = $("#merchant_charge_donut");
    let paid = parseFloat(element.data("paid"));
    let unpaid = parseFloat(element.data("unpaid"));

    // if (paid == 0 && unpaid == 0) {
    //     paid = unpaid = 1;
    // }

    const total = (paid + unpaid).toFixed(2);

    Morris.Donut({
        element: "merchant_charge_donut",
        data: [
            { label: "Paid", value: paid },
            { label: "Total Commission", value: total },
            { label: "Unpaid", value: unpaid },
        ],
        resize: true,
        colors: ["#FFA500", "#0CAF60", "#FF3B3B"],
    });
}

function weeklyCodDonut() {
    const element = $("#cod_donut");
    let hub = Number(element.data("cod-hub"));
    let admin = Number(element.data("cod-admin"));
    let merchant = Number(element.data("cod-merchant"));

    // if (hub == 0 && admin == 0 && merchant == 0) {
    //     hub = admin = merchant = 1;
    // }

    Morris.Donut({
        element: "cod_donut",
        data: [
            { label: "Hub", value: hub },
            { label: "Admin", value: admin },
            { label: "Merchant", value: merchant },
        ],
        resize: true,
        colors: ["#FFA500", "#adb5bd", "#FF3B3B"],
    });
}

function dailyMerchantCharge() {
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
                data: data,
                xkey: "day",
                ykeys: ["paid", "unpaid"],
                labels: ["Total paid", "Total unpaid"],
                fillOpacity: 0.6,
                hideHover: "auto",
                behaveLikeLine: true,
                resize: true,
                pointFillColors: ["#ffffff"],
                pointStrokeColors: ["black"],
                lineColors: ["#adb5bd", "red"],
                parseTime: false,
            };

            Morris.Line(config);
        },
    });
}

// ===================================================

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
                behaveLikeLine: true,
                gridLineColor: "transparent",
                lineWidth: 3,
                hideHover: "auto",
                lineColors: ["#343a40", "#FFA500", "#3f37c9", "#ced4da"],
                pointStrokeColors: ["#3887BE", "#111", "#495057", "#111"],
                resize: true,
                parseTime: false,
                pointFillColors: ["#f8f9fa"],
            };

            Morris.Area(config);
        },
    });
}

function dailyCourierRevenue() {
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
                ykeys: ["charge", "commission"],
                labels: ["Charge", "Commission"],
                barColors: ["#adb5bd", "#0D6EFD"],
                hideHover: "auto",
                gridLineColor: "transparent",
                resize: true,
                barSizeRatio: 0.25,
            };

            Morris.Bar(config);
        },
    });
}

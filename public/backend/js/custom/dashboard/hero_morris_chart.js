"use strict";

$(document).ready(function () {
    dailyCommissionChart();
    weeklyCodChart();
    weeklyCommissionChart();
});

function weeklyCodChart() {
    const element = $("#cod_donut");
    let cod = {
        paid: parseFloat(element.data("paid")),
        payable: parseFloat(element.data("payable")),
    };

    Morris.Donut({
        element: "cod_donut",
        data: [
            { label: "Total", value: cod.paid + cod.payable },
            { label: "Pay to Hub", value: cod.paid },
            { label: "Payable", value: cod.payable },
        ],
        resize: true,
        colors: ["#0d6efd", "#0CAF60", "#FF3B3B"],
    });
}

function weeklyCommissionChart() {
    const element = $("#commission_donut");
    let commission = {
        paid: parseFloat(element.data("paid")),
        unpaid: parseFloat(element.data("unpaid")),
    };
    Morris.Donut({
        element: "commission_donut",
        data: [
            { label: "Total", value: commission.paid + commission.unpaid },
            { label: "Paid", value: commission.paid },
            { label: "Unpaid", value: commission.unpaid },
        ],
        resize: true,
        colors: ["#0d6efd", "#0CAF60", "#FF3B3B"],
    });
}

function dailyCommissionChart() {
    const element = $("#commission_morris_line");
    const url = element.data("url");

    $.ajax({
        type: "post",
        url: url,
        dataType: "json",
        success: function (data) {
            // console.log(data);

            let config = {
                element: "commission_morris_line",
                data: data,
                xkey: "day",
                ykeys: ["paid", "unpaid"],
                labels: ["Paid", "Unpaid"],
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

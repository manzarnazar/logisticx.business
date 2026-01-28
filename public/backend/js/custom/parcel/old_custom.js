let parcel_hub_id = null;

$(document).ready(function () {
    $(".parcel-id").click(function () {
        var parcelId = $(this).data("parcel");
        $(".modal_parcel_id").attr("value", parcelId);

        parcel_hub_id = $(this).data("parcel-hub-id");
    });

    $(".parcel-id-pickup-man").click(function () {
        var parcelId = $(this).data("parcel");
        var status = $(this).data("parcelstatus");
        $(".modal_parcel_id").attr("value", parcelId);

        parcel_hub_id = $(this).data("parcel-hub-id");

        $.ajax({
            type: "POST",
            url: $("#delivery_man_search_reschedule").data("url"),
            data: {
                parcel_id: parcelId,
                single: true,
                status: status,
            },
            dataType: "html",
            success: function (data) {
                $("#delivery_man_search_reschedule").html(data);
            },
        });
    });

    //received by warehouse
    $(".received_warehouse").click(function () {
        var parcelId = $(this).data("parcel");
        var hub = $(this).data("hub");

        $.ajax({
            type: "POST",
            url: $(this).data("url"),
            data: { parcel_id: parcelId, hub_id: hub },
            dataType: "html",
            success: function (data) {
                $(".receivedwarehousehub").html(data);
            },
        });
    });

    $(".parcel-id-delivery-man").click(function () {
        var parcelId = $(this).data("parcel");
        var status = $(this).data("parcelstatus");
        $(".modal_parcel_id").attr("value", parcelId);
        $.ajax({
            type: "POST",
            url: $("#deliverymanreschedule").data("url"),
            data: { parcel_id: parcelId, single: true, status: status },
            dataType: "html",
            success: function (data) {
                $("#deliverymanreschedule").html(data);
            },
        });
    });

    $(".parcel-id-transfer-hub").click(function () {
        var parcelId = $(this).data("parcel");
        $(".modal_parcel_id").attr("value", parcelId);

        parcel_hub_id = $(this).data("parcel-hub-id");

        $.ajax({
            type: "POST",
            url: $("#transfer-hub").data("url"),
            data: { parcel_id: parcelId, single: true },
            dataType: "html",
            success: function (data) {
                $("#transfer-hub").html(data);
            },
        });
    });

    if ($("#received_track_id").val() == null) {
        $(".btn").prop("disabled", true);
    }

    var i = 1;
    var response = false;
    $("#received_track_id").on("keyup", function () {
        const ids = $('input[name="parcel_ids[]"]')
            .map(function () {
                return this.value; // $(this).val()
            })
            .get();

        if (response == false) {
            response = true;

            $.ajax({
                type: "POST",
                url: $("#received_track_id").data("url"),
                data: {
                    track_id: $("#received_track_id").val(),
                    hub_id: $("#received_transfer-hub").val(),
                    single: true,
                },
                dataType: "json",
                success: function (data) {
                    response = false;
                    if (data == 0) {
                        $("#transfer_to_hub_track_id_not_found2").show();
                        $("#transfer_to_hub_track_id_found2").hide();
                        $("#transfer_to_hub_track_id_already_added2").hide();
                    } else if (ids.includes(data["id"].toString())) {
                        $("#transfer_to_hub_track_id_not_found2").hide();
                        $("#transfer_to_hub_track_id_found2").hide();
                        $("#transfer_to_hub_track_id_already_added2").show();
                    } else {
                        $("#transfer_to_hub_track_id_not_found2").hide();
                        $("#transfer_to_hub_track_id_found2").show();
                        $("#transfer_to_hub_track_id_already_added2").hide();

                        var row = "";
                        row += "<tr>";
                        row +=
                            "<td>" +
                            i++ +
                            "<input type='hidden' name='parcel_id[]' value='" +
                            data.id +
                            "'/></td>";
                        row += "<td>" + data.tracking_id + "</td>";
                        row += "<td>" + data.merchant.business_name + "</td>";
                        row += "<td>" + data.customer_phone + "</td>";
                        row += "<td>" + data.delivery_date + "</td>";
                        row += "<td>" + data.cash_collection + "</td>";
                        row +=
                            "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                        row +=
                            '<input type="hidden" value="' +
                            data["id"] +
                            '" name="parcel_ids[]">';
                        row += "</tr>";

                        $("#received_trakings_ids").append(row);
                        document.getElementById("received_track_id").value = "";

                        $(".rowremovebtn").click(function () {
                            $(this).parent().parent().remove();
                            i--;
                        });
                    }
                },
            });
        }
    });

    $("#delivery_man_search_assign").select2({
        ajax: {
            url: $("#delivery_man_search_assign").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $(".delivery_man_search").select2({
        ajax: {
            url: $("#delivery_man_search").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                const hub_id = parcel_hub_id;
                parcel_hub_id = null;
                return {
                    hub_id: hub_id,
                    search: params.term,
                    searchQuery: true,
                };
            },
            processResults: function (response) {
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $(".delivery_man_search_hub").select2({
        ajax: {
            url: $("#delivery_man_search_hub").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                const hub_id = parcel_hub_id;
                parcel_hub_id = null;
                return {
                    hub_id: hub_id,
                    search: params.term,
                    searchQuery: true,
                };
            },
            processResults: function (response) {
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $(".delivery_man_search_hub_multiple_parcel").select2({
        ajax: {
            url: $("#delivery_man_search_hub_multiple_parcel").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $(".delivery_man_assign_search_multiple_parcel").select2({
        ajax: {
            url: $("#delivery_man_assign_search_multiple_parcel").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    // Delivery man assing multiple parcel
    let _sl = 1,
        _submit = 0;
    $("#delivery_man_assign_multiple_parcel_button").prop("disabled", true);
    $("#delivery_man_assign_track_id").on("keyup", function () {
        // parcel id list
        const ids = $('input[name="parcel_ids_[]"]')
            .map(function () {
                return this.value;
            })
            .get();

        var value = $(this).val();
        if (_submit == 0) {
            _submit = 1; // multiple request hande!
            $.ajax({
                type: "post",
                url: "/admin/parcel/search-delivery-man-assing-multiple-parcel",
                data: { search: value, _token: $("#token").val() },
                success: function (data) {
                    setTimeout(function () {
                        _submit = 0;
                        if (data == 0) {
                            $(".search_message_").empty();
                            $(".search_message_").append(
                                '<small class="text-danger">Parcel not found!</small>'
                            );
                        } else if (ids.includes(data["id"].toString())) {
                            $(".search_message_").empty();
                            $(".search_message_").append(
                                '<small class="text-danger">Already added!</small>'
                            );
                        } else {
                            $(".search_message_").empty();
                            $(".search_message_").append(
                                '<small class="text-success">Parcel added successfully.</small>'
                            );
                            $("#_t_body").append(
                                "<tr> <td>" +
                                    _sl++ +
                                    '<input type="hidden" value="' +
                                    data["id"] +
                                    '" name="parcel_ids_[]"></td><td>' +
                                    data["tracking_id"] +
                                    "</td><td>" +
                                    data["merchant"]["business_name"] +
                                    "</td><td>" +
                                    data["merchant"]["user"]["mobile"] +
                                    "</td><td>" +
                                    data["delivery_date"] +
                                    "</td><td>" +
                                    data["cash_collection"] +
                                    '</td><td><i class="fa fa-trash removerow" style="cursor:pointer"></i></td> </tr>'
                            );
                            $("#delivery_man_assign_track_id").val("");
                            $(".removerow").click(function () {
                                $(this).parent().parent().remove();
                                --sl;
                            });
                        }
                    }, 250);
                },
            });
        }
        // else if(value.length > 20 && _submit == 0){
        //     $('.search_message_').empty();
        //     $('.search_message_').append('<small class="text-danger">Maximum 14 characters!</small>');
        // }
        // else{
        //     $('.search_message_').empty();
        //     $('.search_message_').append('<small class="text-danger">Minimum 14 characters!</small>');
        // }

        // on keyup submit button disabled true/false
        if (ids != null && $('input[name="parcel_ids_[]"]') != null) {
            $("#delivery_man_assign_multiple_parcel_button").prop(
                "disabled",
                false
            );
        }

        // row delete
        $("#_t_body").on("click", ".btn", function () {
            $(this).closest("tr").remove();
        });
    });

    onScan.attachTo(document);
    // Register event listener
    document.addEventListener("scan", function (sScancode, data) {
        if (
            sScancode.detail.scanCode != "" &&
            sScancode.detail.scanCode != null
        ) {
            const ids = $('input[name="parcel_ids_[]"]')
                .map(function () {
                    return this.value;
                })
                .get();
            if ($("#delivery_man_assign_track_id").val() != "") {
                $.ajax({
                    type: "post",
                    url: "/admin/parcel/search-delivery-man-assing-multiple-parcel",
                    data: {
                        search: sScancode.detail.scanCode,
                        _token: $("#token").val(),
                    },
                    success: function (data) {
                        setTimeout(function () {
                            if (data == 0) {
                                $(".search_message_").empty();
                                $(".search_message_").append(
                                    '<small class="text-danger">Parcel not found!</small>'
                                );
                            } else if (ids.includes(data["id"].toString())) {
                                $(".search_message_").empty();
                                $(".search_message_").append(
                                    '<small class="text-danger">Already added!</small>'
                                );
                            } else {
                                $(".search_message_").empty();
                                $(".search_message_").append(
                                    '<small class="text-success">Parcel added successfully.</small>'
                                );
                                $("#_t_body").append(
                                    "<tr> <td>" +
                                        _sl++ +
                                        '<input type="hidden" value="' +
                                        data["id"] +
                                        '" name="parcel_ids_[]"></td><td>' +
                                        data["tracking_id"] +
                                        "</td><td>" +
                                        data["merchant"]["business_name"] +
                                        "</td><td>" +
                                        data["merchant"]["user"]["mobile"] +
                                        "</td><td>" +
                                        data["delivery_date"] +
                                        "</td><td>" +
                                        data["cash_collection"] +
                                        '</td><td><i class="fa fa-trash removerow" style="cursor:pointer"></i></td> </tr>'
                                );
                                $("#delivery_man_assign_track_id").val("");
                                $(".removerow").click(function () {
                                    $(this).parent().parent().remove();
                                    --sl;
                                });
                            }
                        }, 250);
                    },
                });
            } else if ($("#received_track_id").val() != "") {
                $.ajax({
                    type: "POST",
                    url: $("#received_track_id").data("url"),
                    data: {
                        track_id: $("#received_track_id").val(),
                        hub_id: $("#received_transfer-hub").val(),
                        single: true,
                    },
                    dataType: "json",
                    success: function (data) {
                        response = false;
                        if (data == 0) {
                            $("#transfer_to_hub_track_id_not_found2").show();
                            $("#transfer_to_hub_track_id_found2").hide();
                            $(
                                "#transfer_to_hub_track_id_already_added2"
                            ).hide();
                        } else if (ids.includes(data["id"].toString())) {
                            $("#transfer_to_hub_track_id_not_found2").hide();
                            $("#transfer_to_hub_track_id_found2").hide();
                            $(
                                "#transfer_to_hub_track_id_already_added2"
                            ).show();
                        } else {
                            $("#transfer_to_hub_track_id_not_found2").hide();
                            $("#transfer_to_hub_track_id_found2").show();
                            $(
                                "#transfer_to_hub_track_id_already_added2"
                            ).hide();

                            var row = "";
                            row += "<tr>";
                            row +=
                                "<td>" +
                                i++ +
                                "<input type='hidden' name='parcel_id[]' value='" +
                                data.id +
                                "'/></td>";
                            row += "<td>" + data.tracking_id + "</td>";
                            row +=
                                "<td>" + data.merchant.business_name + "</td>";
                            row += "<td>" + data.customer_phone + "</td>";
                            row += "<td>" + data.delivery_date + "</td>";
                            row += "<td>" + data.cash_collection + "</td>";
                            row +=
                                "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                            row +=
                                '<input type="hidden" value="' +
                                data["id"] +
                                '" name="parcel_ids[]">';
                            row += "</tr>";

                            $("#received_trakings_ids").append(row);
                            document.getElementById("received_track_id").value =
                                "";

                            $(".rowremovebtn").click(function () {
                                $(this).parent().parent().remove();
                                i--;
                            });
                        }
                    },
                });
            } else if ($("#transfer_to_hub_track_id").val() != "") {
                $.ajax({
                    type: "post",
                    url: "/admin/parcel/search",
                    data: {
                        search: $("#transfer_to_hub_track_id").val(),
                        _token: $("#token").val(),
                    },
                    success: function (data) {
                        setTimeout(function () {
                            if (data == 0) {
                                $(".search_message").empty();
                                $(".search_message").append(
                                    '<small class="text-danger">Parcel not found!</small>'
                                );
                            } else if (ids.includes(data["id"].toString())) {
                                $(".search_message").empty();
                                $(".search_message").append(
                                    '<small class="text-danger">Already added!</small>'
                                );
                            } else {
                                $(".search_message").empty();
                                $(".search_message").append(
                                    '<small class="text-success">Parcel added successfully.</small>'
                                );
                                $("#t_body").append(
                                    "<tr> <td>" +
                                        sl++ +
                                        '<input type="hidden" value="' +
                                        data["id"] +
                                        '" name="parcel_ids[]"></td><td>' +
                                        data["tracking_id"] +
                                        "</td><td>" +
                                        data["hub"]["name"] +
                                        "</td><td>" +
                                        data["merchant"]["business_name"] +
                                        "</td><td>" +
                                        data["merchant"]["user"]["mobile"] +
                                        "</td><td>" +
                                        data["delivery_date"] +
                                        "</td><td>" +
                                        data["cash_collection"] +
                                        '</td><td><i class="fa fa-trash removerow" style="cursor:pointer"></i></td> </tr>'
                                );
                                $("#transfer_to_hub_track_id").val("");
                                $(".removerow").click(function () {
                                    $(this).parent().parent().remove();
                                    --sl;
                                });
                            }
                        }, 250);
                    },
                });
            } else if ($("#return_parcel_tracking_id").val() != "") {
                $.ajax({
                    type: "POST",
                    url: $("#return_parcel_tracking_id").data("url"),
                    data: {
                        tracking_id: $("#return_parcel_tracking_id").val(),
                        merchant_id: $("#return_merchant_bulk_merchant").val(),
                        single: true,
                    },
                    dataType: "json",
                    success: function (data) {
                        response2 = false;
                        if (data == 0) {
                            response2 = false;
                            $("#transfer_to_hub_track_id_not_found4").show();
                            $("#transfer_to_hub_track_id_found4").hide();
                            $(
                                "#transfer_to_hub_track_id_already_added4"
                            ).hide();
                        } else if (ids.includes(data["id"].toString())) {
                            response2 = false;
                            $("#transfer_to_hub_track_id_not_found4").hide();
                            $("#transfer_to_hub_track_id_found4").hide();
                            $(
                                "#transfer_to_hub_track_id_already_added4"
                            ).show();
                        } else {
                            response2 = false;

                            $("#transfer_to_hub_track_id_not_found4").hide();
                            $("#transfer_to_hub_track_id_found4").show();
                            $(
                                "#transfer_to_hub_track_id_already_added4"
                            ).hide();

                            var row = "";
                            row += "<tr>";
                            row +=
                                "<td>" +
                                a++ +
                                "<input type='hidden' name='parcel_id[]' value='" +
                                data.id +
                                "'/></td>";
                            row += "<td>" + data.tracking_id + "</td>";
                            row +=
                                "<td>" + data.merchant.business_name + "</td>";
                            row += "<td>" + data.customer_phone + "</td>";
                            row += "<td>" + data.delivery_date + "</td>";
                            row += "<td>" + data.cash_collection + "</td>";
                            row +=
                                "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                            row +=
                                '<input type="hidden" value="' +
                                data["id"] +
                                '" name="parcel_ids[]">';
                            row += "</tr>";

                            $("#return_parcel_added").append(row);
                            document.getElementById(
                                "return_parcel_tracking_id"
                            ).value = "";

                            $(".rowremovebtn").click(function () {
                                $(this).parent().parent().remove();
                                a--;
                            });
                        }
                    },
                });
            } else if ($("#received_return_parcel_tracking_id").val() != "") {
                $.ajax({
                    type: "POST",
                    url: $("#received_return_parcel_tracking_id").data("url"),
                    data: {
                        tracking_id: $(
                            "#received_return_parcel_tracking_id"
                        ).val(),
                        single: true,
                    },
                    dataType: "json",
                    success: function (data) {
                        res2 = false;
                        if (data == 0) {
                            res2 = false;
                            $(
                                "#received_return_to_merchant_track_id_not_found4"
                            ).show();
                            $(
                                "#received_return_to_merchant_track_id_found4"
                            ).hide();
                            $(
                                "#received_return_to_merchant_track_id_already_added4"
                            ).hide();
                        } else if (ids.includes(data["id"].toString())) {
                            res2 = false;
                            $(
                                "#received_return_to_merchant_track_id_not_found4"
                            ).hide();
                            $(
                                "#received_return_to_merchant_track_id_found4"
                            ).hide();
                            $(
                                "#received_return_to_merchant_track_id_already_added4"
                            ).show();
                        } else {
                            res2 = false;

                            $(
                                "#received_return_to_merchant_track_id_not_found4"
                            ).hide();
                            $(
                                "#received_return_to_merchant_track_id_found4"
                            ).show();
                            $(
                                "#received_return_to_merchant_track_id_already_added4"
                            ).hide();

                            var row = "";
                            row += "<tr>";
                            row +=
                                "<td>" +
                                b++ +
                                "<input type='hidden' name='parcel_id[]' value='" +
                                data.id +
                                "'/></td>";
                            row += "<td>" + data.tracking_id + "</td>";
                            row +=
                                "<td>" + data.merchant.business_name + "</td>";
                            row += "<td>" + data.customer_phone + "</td>";
                            row += "<td>" + data.delivery_date + "</td>";
                            row += "<td>" + data.cash_collection + "</td>";
                            row +=
                                "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                            row +=
                                '<input type="hidden" value="' +
                                data["id"] +
                                '" name="parcel_ids[]">';
                            row += "</tr>";

                            $("#return_received_parcel_added").append(row);
                            document.getElementById(
                                "received_return_parcel_tracking_id"
                            ).value = "";

                            $(".rowremovebtn").click(function () {
                                $(this).parent().parent().remove();
                                a--;
                            });
                        }
                    },
                });
            }
        }
    });

    // Transfer to hub multiple parcel
    let sl = 1,
        submit = 0;
    $("#transfer_to_hub_multiple_parcel_button").prop("disabled", true);

    $("#transfer_to_hub_track_id").on("keyup", function () {
        // parcel id list
        const ids = $('input[name="parcel_ids[]"]')
            .map(function () {
                return this.value;
            })
            .get();

        var value = $(this).val();
        if (value.length <= 20 && submit == 0) {
            submit = 1; // multiple request hande!
            $.ajax({
                type: "post",
                url: "/admin/parcel/search",
                data: { search: value, _token: $("#token").val() },
                success: function (data) {
                    console.log(data);
                    setTimeout(function () {
                        submit = 0;
                        if (data == 0) {
                            $(".search_message").empty();
                            $(".search_message").append(
                                '<small class="text-danger">Parcel not found!</small>'
                            );
                        } else if (ids.includes(data["id"].toString())) {
                            $(".search_message").empty();
                            $(".search_message").append(
                                '<small class="text-danger">Already added!</small>'
                            );
                        } else {
                            $(".search_message").empty();
                            $(".search_message").append(
                                '<small class="text-success">Parcel added successfully.</small>'
                            );
                            // $("#t_body").append(
                            //     "<tr> <td>" +
                            //         sl++ +
                            //         '<input type="hidden" value="' +
                            //         data["id"] +
                            //         '" name="parcel_ids[]"></td><td>' +
                            //         data["tracking_id"] +
                            //         "</td><td>" +
                            //         data["hub"]["name"] +
                            //         "</td><td>" +
                            //         data["merchant"]["business_name"] +
                            //         "</td><td>" +
                            //         data["merchant"]["user"]["mobile"] +
                            //         "</td><td>" +
                            //         data["delivery_date"] +
                            //         "</td><td>" +
                            //         data["cash_collection"] +
                            //         '</td><td><i class="fa fa-trash removerow" style="cursor:pointer"></i></td> </tr>'
                            // );

                            $("#t_body").append(
                                `<tr> 
                                    <td>${sl++}<input type="hidden" value="${
                                    data["id"]
                                }" name="parcel_ids[]"></td>
                                    <td>${data["tracking_id"]}</td>
                                    
                                    <td>${
                                        data["merchant"]["business_name"]
                                    }</td>
                                    <td>${
                                        data["merchant"]["user"]["mobile"]
                                    }</td>
                                    <td>${data["delivery_date"]}</td>
                                    <td>${data["cash_collection"]}</td>
                                    <td><i class="fa fa-trash removerow" style="cursor:pointer"></i></td> 
                                </tr>`
                            );

                            $("#transfer_to_hub_track_id").val("");
                            $(".removerow").click(function () {
                                $(this).parent().parent().remove();
                                --sl;
                            });
                        }
                    }, 250);
                },
            });
        } else if (value.length > 20 && submit == 0) {
            $(".search_message").empty();
            $(".search_message").append(
                '<small class="text-danger">Maximum 14 characters!</small>'
            );
        } else {
            $(".search_message").empty();
            $(".search_message").append(
                '<small class="text-danger">Minimum 14 characters!</small>'
            );
        }

        // on keyup submit button disabled true/false
        if (ids != null && $("#transfer_hub").val() != null) {
            $("#transfer_to_hub_multiple_parcel_button").prop(
                "disabled",
                false
            );
        }

        // row delete
        $("#t_body").on("click", ".btn", function () {
            $(this).closest("tr").remove();
        });
    });

    // on change submit button disabled true/false
    $("#transfer_hub").on("change", function () {
        if (
            $('input[name="parcel_ids[]"]').val() != null &&
            $("#transfer_hub").val() != null
        ) {
            $("#transfer_to_hub_multiple_parcel_button").prop(
                "disabled",
                false
            );
        }
    });

    $(".delivery_man_search_redelivery").select2({
        ajax: {
            url: $("#delivery_man_search_redelivery").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $("#deliverymanreschedule").select2({
        ajax: {
            url: $("#deliverymanreschedule").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $("#returnassigntomerchant").select2({
        ajax: {
            url: $("#returnassigntomerchant").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    $("#returnassigntomerchantReschedule").select2({
        ajax: {
            url: $("#returnassigntomerchant").data("url"),
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
                console.log(response);
                return {
                    results: response,
                };
            },
            cache: true,
        },
    });

    //Assign pickup man bulk

    $("#pickup_bulk_merchant").select2({
        ajax: {
            url: $("#pickup_bulk_merchant").data("url"),
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

    var a = 1;
    var response2 = false;
    $("#assign_pickup_btn").prop("disabled", true);
    $("#pickup_parcel_tracking_id").on("keyup", function () {
        if ($("#picup_bulk_merchant").val() !== null) {
            $("#assign_pickup_btn").prop("disabled", false);
        } else {
            $("#assign_pickup_btn").prop("disabled", true);
        }

        const ids = $('input[name="parcel_ids[]"]')
            .map(function () {
                return this.value;
            })
            .get();

        if (response2 == false) {
            response2 = true;

            $.ajax({
                type: "POST",
                url: $("#pickup_parcel_tracking_id").data("url"),
                data: {
                    tracking_id: $("#pickup_parcel_tracking_id").val(),
                    merchant_id: $("#pickup_bulk_merchant").val(),
                    single: true,
                },
                dataType: "json",
                success: function (data) {
                    response2 = false;
                    if (data == 0) {
                        response2 = false;
                        $("#transfer_to_hub_track_id_not_found3").show();
                        $("#transfer_to_hub_track_id_found3").hide();
                        $("#transfer_to_hub_track_id_already_added3").hide();
                    } else if (ids.includes(data["id"].toString())) {
                        response2 = false;
                        $("#transfer_to_hub_track_id_not_found3").hide();
                        $("#transfer_to_hub_track_id_found3").hide();
                        $("#transfer_to_hub_track_id_already_added3").show();
                    } else {
                        response2 = false;

                        $("#transfer_to_hub_track_id_not_found3").hide();
                        $("#transfer_to_hub_track_id_found3").show();
                        $("#transfer_to_hub_track_id_already_added3").hide();

                        var row = "";
                        row += "<tr>";
                        row +=
                            "<td>" +
                            a++ +
                            "<input type='hidden' name='parcel_id[]' value='" +
                            data.id +
                            "'/></td>";
                        row += "<td>" + data.tracking_id + "</td>";
                        row += "<td>" + data.merchant.business_name + "</td>";
                        row += "<td>" + data.customer_phone + "</td>";
                        row += "<td>" + data.delivery_date + "</td>";
                        row += "<td>" + data.cash_collection + "</td>";
                        row +=
                            "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                        row +=
                            '<input type="hidden" value="' +
                            data["id"] +
                            '" name="parcel_ids[]">';
                        row += "</tr>";

                        $("#pickup_parcel_added").append(row);
                        document.getElementById(
                            "pickup_parcel_tracking_id"
                        ).value = "";

                        $(".rowremovebtn").click(function () {
                            $(this).parent().parent().remove();
                            a--;
                        });
                    }
                },
            });
        }
    });

    //assign return to merchant

    $("#return_merchant_bulk_merchant").select2({
        ajax: {
            url: $("#return_merchant_bulk_merchant").data("url"),
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

    var a = 1;
    var response2 = false;
    $("#assign_return_merchant_btn").prop("disabled", true);
    $("#return_parcel_tracking_id").on("keyup", function () {
        if ($("#picup_bulk_merchant").val() !== null) {
            $("#assign_return_merchant_btn").prop("disabled", false);
        } else {
            $("#assign_return_merchant_btn").prop("disabled", true);
        }

        const ids = $('input[name="parcel_ids[]"]')
            .map(function () {
                return this.value;
            })
            .get();

        if (response2 == false) {
            response2 = true;

            $.ajax({
                type: "POST",
                url: $("#return_parcel_tracking_id").data("url"),
                data: {
                    tracking_id: $("#return_parcel_tracking_id").val(),
                    merchant_id: $("#return_merchant_bulk_merchant").val(),
                    single: true,
                },
                dataType: "json",
                success: function (data) {
                    response2 = false;
                    if (data == 0) {
                        response2 = false;
                        $("#transfer_to_hub_track_id_not_found4").show();
                        $("#transfer_to_hub_track_id_found4").hide();
                        $("#transfer_to_hub_track_id_already_added4").hide();
                    } else if (ids.includes(data["id"].toString())) {
                        response2 = false;
                        $("#transfer_to_hub_track_id_not_found4").hide();
                        $("#transfer_to_hub_track_id_found4").hide();
                        $("#transfer_to_hub_track_id_already_added4").show();
                    } else {
                        response2 = false;

                        $("#transfer_to_hub_track_id_not_found4").hide();
                        $("#transfer_to_hub_track_id_found4").show();
                        $("#transfer_to_hub_track_id_already_added4").hide();

                        var row = "";
                        row += "<tr>";
                        row +=
                            "<td>" +
                            a++ +
                            "<input type='hidden' name='parcel_id[]' value='" +
                            data.id +
                            "'/></td>";
                        row += "<td>" + data.tracking_id + "</td>";
                        row += "<td>" + data.merchant.business_name + "</td>";
                        row += "<td>" + data.customer_phone + "</td>";
                        row += "<td>" + data.delivery_date + "</td>";
                        row += "<td>" + data.cash_collection + "</td>";
                        row +=
                            "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                        row +=
                            '<input type="hidden" value="' +
                            data["id"] +
                            '" name="parcel_ids[]">';
                        row += "</tr>";

                        $("#return_parcel_added").append(row);
                        document.getElementById(
                            "return_parcel_tracking_id"
                        ).value = "";

                        $(".rowremovebtn").click(function () {
                            $(this).parent().parent().remove();
                            a--;
                        });
                    }
                },
            });
        }
    });

    //assign received return to merchant

    var b = 1;
    var res2 = false;
    $("#received_return_merchant_btn").prop("disabled", true);
    $("#received_return_parcel_tracking_id").on("keyup", function () {
        if ($("#picup_bulk_merchant").val() !== null) {
            $("#received_return_merchant_btn").prop("disabled", false);
        } else {
            $("#received_return_merchant_btn").prop("disabled", true);
        }

        const ids = $('input[name="parcel_ids[]"]')
            .map(function () {
                return this.value;
            })
            .get();

        if (res2 == false) {
            res2 = true;

            $.ajax({
                type: "POST",
                url: $("#received_return_parcel_tracking_id").data("url"),
                data: {
                    tracking_id: $("#received_return_parcel_tracking_id").val(),
                    single: true,
                },
                dataType: "json",
                success: function (data) {
                    res2 = false;
                    if (data == 0) {
                        res2 = false;
                        $(
                            "#received_return_to_merchant_track_id_not_found4"
                        ).show();
                        $(
                            "#received_return_to_merchant_track_id_found4"
                        ).hide();
                        $(
                            "#received_return_to_merchant_track_id_already_added4"
                        ).hide();
                    } else if (ids.includes(data["id"].toString())) {
                        res2 = false;
                        $(
                            "#received_return_to_merchant_track_id_not_found4"
                        ).hide();
                        $(
                            "#received_return_to_merchant_track_id_found4"
                        ).hide();
                        $(
                            "#received_return_to_merchant_track_id_already_added4"
                        ).show();
                    } else {
                        res2 = false;

                        $(
                            "#received_return_to_merchant_track_id_not_found4"
                        ).hide();
                        $(
                            "#received_return_to_merchant_track_id_found4"
                        ).show();
                        $(
                            "#received_return_to_merchant_track_id_already_added4"
                        ).hide();

                        var row = "";
                        row += "<tr>";
                        row +=
                            "<td>" +
                            b++ +
                            "<input type='hidden' name='parcel_id[]' value='" +
                            data.id +
                            "'/></td>";
                        row += "<td>" + data.tracking_id + "</td>";
                        row += "<td>" + data.merchant.business_name + "</td>";
                        row += "<td>" + data.customer_phone + "</td>";
                        row += "<td>" + data.delivery_date + "</td>";
                        row += "<td>" + data.cash_collection + "</td>";
                        row +=
                            "<td><label class='rowremovebtn' style='cursor:pointer'><i  class='fa fa-trash '></i></label></td>";
                        row +=
                            '<input type="hidden" value="' +
                            data["id"] +
                            '" name="parcel_ids[]">';
                        row += "</tr>";

                        $("#return_received_parcel_added").append(row);
                        document.getElementById(
                            "received_return_parcel_tracking_id"
                        ).value = "";

                        $(".rowremovebtn").click(function () {
                            $(this).parent().parent().remove();
                            a--;
                        });
                    }
                },
            });
        }
    });

    //select assign type
    $("#selectAssignType").on("change", function () {
        var type = $(this).val();
        $("#" + type).modal("show");
    });
});

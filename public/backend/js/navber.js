"use strict";

$(document).ready(function () {
    getUsersForToDoAssign();
});

$("#search").on("input", function () {
    $.ajax({
        type: "post",
        url: $(this).data("url"),
        data: { search: $(this).val() },
        dataType: "html",
        success: function (data) {
            console.log(data);
            $("#route_list").html(data);
        },
    });
});

$("#search").on("change", function () {
    // Submit the form when an option is selected from the datalist
    $(this).closest("form").submit();
});

// window.scrollTo({ top: 900, behavior: 'smooth' })

// Sibear Scroll on half expand start
let interSectedLastItemOfElement = false;

let sidebarOffsetTop = $(".quixnav-scroll").offset().top;

sidebarOffsetTop = 0;

let scrollTop = sidebarOffsetTop;

$(".quixnav").on("wheel", function (event) {
    let direction = event.originalEvent.deltaY;

    if (direction > 0) {
        scrollTop = scrollTop - 10;

        if (!interSectedLastItemOfElement) {
            $(".quixnav-scroll").css("top", `${scrollTop}px`);
        }
    } else {
        if (sidebarOffsetTop > scrollTop) {
            interSectedLastItemOfElement = false;
            scrollTop = scrollTop + 10;
            $(".quixnav-scroll").css("top", `${scrollTop}px`);
        }
    }
});

function getUsersForToDoAssign() {
    $(".todo_assign_user").select2({
        placeholder: "Select User",
        ajax: {
            url: $(".todo_assign_user").data("url"),
            type: "POST",
            dataType: "json",
            delay: 250,
            data: function (params) {
                let skip = $(".todo_assign_user").data("skip-user-type");
                return {
                    search: params.term,
                    name: params.term,
                    select2: true,
                    skip_user_type: skip,
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

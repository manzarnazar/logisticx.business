/* ======== sidebar active link and dropdown menu =========*/

$(function () {
    $("#toggleSidebar").click(function () {
        if (window.innerWidth < 992) {
            $("#sidebar").toggleClass("show");
            $("#overlay").toggle($("#sidebar").hasClass("show"));
        } else {
            $("body").toggleClass("hidden-sidebar");
            $("#main-content").toggleClass("with-sidebar");
        }
    });

    $("#overlay").click(function () {
        $("#sidebar").removeClass("show");
        $(this).hide();
    });

    $(".has-submenu > a").click(function (e) {
        e.preventDefault();

        const $parent = $(this).parent();

        // Close all others smoothly
        $(".has-submenu").not($parent).removeClass("open").find(".submenu").slideUp(200);

        // Toggle current submenu
        $parent.toggleClass("open");

        // Slide current submenu
        $parent.find(".submenu").stop(true, true).slideToggle(200);
    });

    // -------------------------
    // Auto Active Menu on Page Load
    // -------------------------
    const currentUrl = window.location.origin + window.location.pathname;
    // console.log("✅ Current URL:", currentUrl);
    $("#sidebar a").each(function () {
        const linkUrl = this.href;
        // console.log("🔗 Link URL:", linkUrl);
        // ✅ Match partial URLs instead of exact match
        if (linkUrl && currentUrl.startsWith(linkUrl) ) {
            $(this).addClass("active");

            $(this).parents(".has-submenu").each(function () {
                $(this).addClass("open");
                $(this).children(".submenu").show();
            });
        }
    });

});


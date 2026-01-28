"use strict";

$(document).ready(function () {
    $(document).on('click', '.modalBtn', function (e) {
        e.preventDefault();

        const title = this.dataset.title;
        const modalSize = this.dataset.modalsize;
        const url = this.dataset.url || this.getAttribute("href");

        $("#modalSize").removeClass(["modal-sm", "modal-lg", "modal-xl"]);
        if (modalSize) $("#modalSize").addClass(modalSize);

        if (title) {
            $(".modal-header").show();
            $(".modal-title").text(title);
        } else {
            $(".modal-header").hide();
        }

        $('#modal-main-content').html('');
        $('#modal-loader').show();

        $.ajax({ url: url, type: 'get', dataType: 'html' })
            .done(function (data) {
                $('#modal-main-content').html('');
                $('#modal-main-content').html(data);
                $('#modal-loader').hide();
            })
            .fail(function () {
                $('#modal-main-content').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong...');
                $('#modal-loader').hide();
            });
    });
});

"use strict";

function pleaseConfirm(event) {
    event.preventDefault(); // Prevent the default behavior of the link

    const element = event.target;
    const url = element.getAttribute("href");
    const title = element.textContent;
    const question = element.getAttribute("data-question") || "Are you sure?";

    Swal.fire({
        title: title,
        text: question,
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#FF0303",
        confirmButtonText: "Confirm",

        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
    }).then(async (result) => {
        if (result.isConfirmed) {
            try {
                const response = await fetch(url);
                const data = await response.json();

                if (data.status) {
                    alertMessage(data.message, "success");
                    $(element).parents("tr").fadeOut(2000);
                } else {
                    alertMessage(data.message, "error");
                }
            } catch (error) {
                Swal.fire("internal server error", "500", "error");
            }
        }
    });
}

// ONLICK BROUSE FILE UPLOADER
var fileInp = document.getElementById("fileBrouse");
var fileInp2 = document.getElementById("fileBrouse2");
var fileInp3 = document.getElementById("fileBrouse3");
var fileInp4 = document.getElementById("fileBrouse4");

if (fileInp) {
    fileInp.addEventListener("change", showFileName);

    function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder").placeholder = fileName;
    }
}

if (fileInp2) {
    fileInp2.addEventListener("change", showFileName);

    function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder2").placeholder = fileName;
    }
}

if (fileInp3) {
    fileInp3.addEventListener("change", showFileName);

    function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder3").placeholder = fileName;
    }
}
if (fileInp4) {
    fileInp4.addEventListener("change", showFileName);

    function showFileName(event) {
        var fileInp = event.srcElement;
        var fileName = fileInp.files[0].name;
        document.getElementById("placeholder4").placeholder = fileName;
    }
}

// updated version for image upload
$(document).ready(function () {
    $(".ot_fileUploader input[type=file]").change(function () {
        fileUploadEffect($(this));
    });
});

function fileUploadEffect(element) {
    var file = element.get(0).files[0];

    if (file) {
        var reader = new FileReader();
        reader.onload = function (e) {
            element
                .closest(".ot_fileUploader")
                .find("img")
                .attr("src", e.target.result);
            element
                .closest(".ot_fileUploader")
                .find(".placeholder")
                .val(file.name);
        };
        reader.readAsDataURL(file);
    }
}

function searchOnTable(searchText = "", tableId = "table") {
    searchText = searchText.toLowerCase();
    const rows = document.querySelectorAll(`#${tableId} tbody tr`);
    rows.forEach((row) => {
        const rowData = row.textContent.toLowerCase();
        if (rowData.indexOf(searchText) === -1) {
            row.style.display = "none";
        } else {
            row.style.display = "";
        }
    });
}

async function submitForm(event) {
    event.preventDefault();

    const form = event.target; // Accessing the form from the event
    const url = form.getAttribute("action"); // get action url
    const formData = new FormData(form); // access form data

    const errorBoxes = form.querySelectorAll(".errorTextBox"); // access all error boxes
    errorBoxes.forEach((elm) => elm.classList.add("d-none")); // hide all error boxes

    const submitBtn = form.querySelector('button[type="submit"]'); // Target submit button
    const buttonText = submitBtn.innerHTML; // Get default button text

    const iconElement = document.createElement("i"); // Create i tag for fa icon

    iconElement.className = "fa fa-spinner fa-spin"; // Add fa icon class to i tag
    submitBtn.textContent = submitBtn.getAttribute("data-loading-text"); // Change the submit button text
    submitBtn.appendChild(iconElement); // Append the icon to the button
    submitBtn.disabled = true; // Disable the submit button

    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData,
            headers: { Accept: "application/json" },
        });

        const data = await response.json();

        if (response.ok && data.status) {
            form.reset();
            if (data.data.redirect_url) {
                window.location.href = data.data.redirect_url;
            }

            if (typeof alertMessage === "function") {
                alertMessage(data.message, "success");
            }

            if ($(".modal").length) {
                $(".modal").modal("hide");
            }

            return;
        }

        if (!data.status && data.message) {
            if (typeof alertMessage === "function") {
                alertMessage(data.message, "error");
            }
        }

        if (data.errors) {
            Object.entries(data.errors).forEach(([key, value]) => {
                let element = form.querySelector(`[name="${key}"]`);
                let errorElm = form.querySelector(`[data-error-for="${key}"]`);
                if (errorElm) {
                    errorElm.textContent = value;
                    errorElm.classList.remove("d-none");
                } else {
                    if (typeof alertMessage === "function") {
                        alertMessage(data.message, "error");
                    }
                }
                if (element) {
                    element.addEventListener("change", function () {
                        errorElm ? errorElm.classList.add("d-none") : "";
                    });
                }
            });
        }
    } catch (error) {
        // console.log(error);
        // alertMessage("Something went wrong, pls try again later", "error");
    } finally {
        submitBtn.disabled = false;
        submitBtn.innerHTML = buttonText;
    }
}

function alertMessage(message, icon = "error") {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener("mouseenter", Swal.stopTimer);
            toast.addEventListener("mouseleave", Swal.resumeTimer);
        },
    });

    Toast.fire({
        icon: icon,
        title: message,
    });
}

$(document).ready(function () {
    $(".flatpickr").flatpickr({
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

    $(".flatpickr-range").flatpickr({
        mode: "range",
        altInput: true,
        altFormat: "F j, Y",
        dateFormat: "Y-m-d",
    });

    $('input[type="time"]').flatpickr({
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i:S",
        altInput: true,
        altFormat: "H:i K",
    });

    $(".summernote").summernote({
        inheritPlaceholder: true,
        height: 182,
        toolbar: [
            ["style", ["bold", "italic", "underline", "clear"]],
            ["font", ["fontname", "fontsize", "forecolor", "backcolor"]],
            ["para", ["ul", "ol", "paragraph"]],
            ["table", ["table"]],
            ["insert", ["link", "picture"]],
        ],
    });

    $(".summernote-2").summernote({
        inheritPlaceholder: true,
        toolbar: [
            ["font", ["bold", "italic", "underline", "clear"]],
            ["style", ["fontname", "fontsize", "forecolor", "backcolor"]],
        ],
    });
});

function copyText(elementId, success_text = "Copy Successful") {
    var copyText = document.getElementById(elementId);
    copyText.select();
    copyText.setSelectionRange(0, 99999); /*For mobile devices*/
    document.execCommand("copy");

    if (typeof alertMessage === "function") {
        alertMessage(success_text, "success");
    }
}

if (typeof pleaseConfirm !== "function") {
    function pleaseConfirm(event) {
        event.preventDefault(); // Prevent the default behavior of the link

        const element = event.target;
        const url = element.getAttribute("href");
        const title = element.textContent;
        const question =
            element.getAttribute("data-question") || "Are you sure?";

        Swal.fire({
            title: title,
            text: question,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#FF0303",
            confirmButtonText: "Confirm",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url; // Redirect to the URL
            }
        });
    }
}


document.addEventListener('DOMContentLoaded', function () {
    // Get all radio buttons
    const noneRadio = document.getElementById('none');
    const bgColorRadio = document.getElementById('bg_color');
    const bgImageRadio = document.getElementById('bg_image');

    // Get the elements for color picker and image uploader
    const colorPickerDiv = document.getElementById('_bg_color');
    const imageUploaderDiv = document.getElementById('_bg_image');

    // Function to handle changes when a radio button is selected
    function handleBackgroundSelection() {
        // Hide both color picker and image uploader by default
        colorPickerDiv?.classList.add('d-none');
        imageUploaderDiv?.classList.add('d-none');

        // Show the relevant input based on selection
        if (bgColorRadio?.checked) {
            colorPickerDiv.classList.remove('d-none');
        } else if (bgImageRadio?.checked) {
            imageUploaderDiv.classList.remove('d-none');
        }
    }

    // Initial check to set visibility based on selected option
    handleBackgroundSelection();

    // Event listeners for radio button changes
    noneRadio?.addEventListener('change', handleBackgroundSelection);
    bgColorRadio?.addEventListener('change', handleBackgroundSelection);
    bgImageRadio?.addEventListener('change', handleBackgroundSelection);
});


function initSelect2() {
    if (typeof $.fn.select2 === "undefined") return;

    $(document).on("select2:open", (e) => {
        const element = e.target;
        const text = element.dataset.searchPlaceholder || "Type to search...";
        $(".select2-search__field").attr("placeholder", text);
    });

    $(".select2").each(function () {
        if (!$(this).is("select")) return;
        if ($(this).hasClass("select2-hidden-accessible")) return;
        const preview = this.dataset.placeholder || $(this).attr("placeholder");
        const optionCount = $(this).find("option").length;
        $(this).select2({
            allowClear: this.dataset.clear ?? true,
            tags: this.dataset.tag || false,
            placeholder: preview || "Select an option",
            minimumResultsForSearch: optionCount <= 5 ? Infinity : 0,
        });
    });

    $(".search-select2").each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) return;
        const preview = this.dataset.placeholder || $(this).attr("placeholder");
        $(this).select2({
            allowClear: this.dataset.clear ?? true,
            tags: this.dataset.tag || false,
            placeholder: preview || "Select an option",
            ajax: {
                url: $(this).data("url"),
                type: "get",
                dataType: "json",
                delay: 250,
                data: (search) => {
                    let params = $(this).data("params");
                    return { search: search.term, select2: true, ...params };
                },
                processResults: function (response) {
                    if (!response.status) swalAlert(response.message);
                    return { results: response.data };
                },
                cache: true,
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
            },
        });
    });

    function formatOption(option) {
        if (!option.id) return option.text;
        let text = option.text;
        return $('<span><i class="' + option.id + '"></i> ' + text + "</span>");
    }

    $(".icon-select2").each(function () {
        if ($(this).hasClass("select2-hidden-accessible")) return;
        const preview = this.dataset.placeholder || $(this).attr("placeholder");
        $(this).select2({
            allowClear: true,
            placeholder: preview || "Select an option",
            templateResult: formatOption,
            templateSelection: formatOption,
        });
    });
}


document.addEventListener('DOMContentLoaded', function () {
    initSelect2();

    $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });

    document.documentElement.setAttribute('dir', document.body.getAttribute('dir')); // to prevent html tag dir changing by  backend/vendor/global/global.min.js file 
});
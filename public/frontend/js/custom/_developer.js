
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
        submitBtn.disabled  = false;
        submitBtn.innerHTML = buttonText;
    }
}

function showPopup(imageUrl) {
    document.getElementById('popupImage').src = imageUrl;
    document.getElementById('imagePopup').style.display = 'block';
}
function hidePopup() {
    document.getElementById('imagePopup').style.display = 'none';
}






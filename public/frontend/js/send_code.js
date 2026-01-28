"use strict";

// $(document).ready(function () {
//     $("#resend").submit(submitForm);
// });

async function submitForm(event) {
    event.preventDefault();

    const form = event.target; // Accessing the form from the event

    const url = form.getAttribute("action"); // get from action url

    const formData = new FormData(form); // get form data

    const submitBtn = form.querySelector('a[id="resend_code_submit_btn"]'); // Select submit button

    let buttonText = submitBtn.textContent; // Hold submit button text

    const iconElement = document.createElement("i"); // create i for fa icon
    iconElement.className = "fa-solid fa-rotate fa-spin"; // add fa class

    submitBtn.textContent = "Processing... "; // change submit button text

    submitBtn.appendChild(iconElement); // Append the icon to the button

    submitBtn.disabled = true; // Disable the submit

    form.querySelectorAll(".error-text").forEach((element) =>
        element.classList.add("d-none")
    );

    try {
        const response = await fetch(url, {
            method: "POST",
            body: formData,
            headers: {
                Accept: "application/json",
            },
        });

        const data = await response.json(); // Parse JSON response

        if (response.ok && data.status_code == 201) {
            form.reset();
            alertMessage(data.message, "success");
        }

        if (data.errors) {
            validationError(data.errors, form);
        }
    } catch (error) {
        alertMessage("Something went wrong, pls try again later", "error");
        console.error("Error:", error);
    } finally {
        submitBtn.disabled = false;
        submitBtn.textContent = buttonText;
    }
}

function validationError(errors, form) {
    Object.entries(errors).forEach(([key, value]) => {
        let formElement = form.querySelector(`[name="${key}"]`); // Find the form element with the name attribute equal to the key
        if (!formElement) {
            return;
        }

        let errorElement = formElement
            .closest("div")
            .querySelector(".error-text");

        if (errorElement) {
            errorElement.classList.remove("d-none");
            errorElement.innerHTML = value;
        }
    });
}

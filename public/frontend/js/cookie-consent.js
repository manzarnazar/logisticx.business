"use strict";

document.addEventListener('DOMContentLoaded', function () {
    // Wait for the page to fully load, so we can apply the fade-in effect
    window.addEventListener("load", () => {
        const banner = document.querySelector("#cookie-consent");
        if (banner) setTimeout(() => banner.classList.add("show"), 2000);
    });

    const actionButtons = document.querySelectorAll("[data-cookie-accept]");

    actionButtons.forEach(btn => btn.addEventListener('click', handlePolicyConsentAction));
});

function handlePolicyConsentAction(event) {
    const btn = event.target;

    btn.disabled = true; // Disable the button to avoid double-clicking

    const actionUrl = btn.closest('[data-action-url]').dataset.actionUrl;

    fetch(actionUrl, {
        method: 'PUT',
        headers: {
            'Accept': 'application/json',
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ cookie_consent: btn.dataset.cookieAccept })
    })
        .then(response => {
            if (!response.ok) throw new Error("Network response was not ok");

            return response.json();
        })
        .then(data => {
            const banner = btn.closest(".fixed-banner");

            banner.classList.add("fade-out"); // Fade-out before removing the banner

            setTimeout(() => banner.remove(), 500); // After fade-out transition ends, remove the banner from DOM and matches the duration of the fade-out transition
        })
        .catch(error => {
            console.error(error);
            btn.disabled = false; // In case of error, re-enable the button
        });
}
"use strict";

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".contact-form-requ").forEach((form) => {
        setupForm(form);
    });
});

function setupForm(form) {
    let area = "outside_city",
        pickup,
        destination,
        pcID,
        stID,
        charge = 0.0;
    const serviceTypeCache = new Map();
    let serviceTypeTimeout = null;

    function setupCustomSelect(selectWrapper, hiddenInputId, callback = null) {
        if (!selectWrapper) return;

        const selectBox = selectWrapper.querySelector(".select-box");
        selectBox.addEventListener("click", () => {
            selectWrapper.classList.toggle("open");
        });

        const optionsContainer = selectWrapper.querySelector("ul.options");
        optionsContainer.addEventListener("click", function (event) {
            const li = event.target.closest("li");
            if (!li) return;

            const text = li.textContent.trim();
            const value = li.getAttribute("data-id") || "";

            selectWrapper.querySelector(".selected-text").textContent = text;
            const hiddenInput = form.querySelector(`#${hiddenInputId}`);
            if (hiddenInput) hiddenInput.value = value;

            selectWrapper.classList.remove("open");

            if (callback) callback(value);
        });
    }

    setupCustomSelect(
        form.querySelector(".pickup_area"),
        "pickup_area_input",
        detectArea
    );
    setupCustomSelect(
        form.querySelector(".delivery_area"),
        "delivery_area_input",
        detectArea
    );
    setupCustomSelect(
        form.querySelector(".product_category"),
        "product_category_input",
        serviceTypeDebounced
    );
    setupCustomSelect(
        form.querySelector(".service_type"),
        "service_type_input",
        getCharge
    );

    const calcBtn = form.querySelector(".calculate-charge-btn");
    if (calcBtn) {
        calcBtn.addEventListener("click", function (e) {
            e.preventDefault();
            getCharge();
        });
    }

    function detectArea() {
        pickup = form.querySelector("#pickup_area_input")?.value || "";
        destination = form.querySelector("#delivery_area_input")?.value || "";

        if (!pickup || !destination) {
            area = "outside_city";
            serviceTypeDebounced();
            return;
        }

        $.ajax({
            type: "POST",
            url: form.querySelector("#area")?.dataset.url,
            data: { pickup_id: pickup, destination_id: destination },
            dataType: "json",
            success: (data) => {
                area = data.area || "outside_city";
                serviceTypeDebounced();
            },
            error: () => {
                area = "outside_city";
                serviceTypeDebounced();
            },
        });
    }

    function serviceTypeDebounced() {
        if (serviceTypeTimeout) clearTimeout(serviceTypeTimeout);
        serviceTypeTimeout = setTimeout(serviceType, 200);
    }

    function serviceType() {
        const serviceTypeWrapper = form.querySelector(".service_type");
        const serviceTypeList = serviceTypeWrapper?.querySelector(".options");

        if (!serviceTypeWrapper || !serviceTypeList) return;

        const label = serviceTypeWrapper.dataset.label || "Service Type";
        const placeholder =
            serviceTypeWrapper.dataset.placeholder || "Select Service Type";

        serviceTypeWrapper.querySelector(".selected-text").textContent = label;
        serviceTypeList.innerHTML = `<li data-id="">${placeholder}</li>`;

        pcID = form.querySelector("#product_category_input")?.value || "";
        if (!pcID || !area) return;

        const cacheKey = `${pcID}_${area}`;
        const chargeEl = form.querySelector(".charge");
        if (chargeEl) chargeEl.textContent = "Searching Service Types...";

        if (serviceTypeCache.has(cacheKey)) {
            populateServiceTypes(serviceTypeCache.get(cacheKey));
            if (chargeEl) {
                const currency = chargeEl.dataset.currency || "";
                const label = chargeEl.dataset.label || "Total Delivery Cost";
                chargeEl.textContent = `${label} ${currency} 0.00`;
            }
            return;
        }

        $.ajax({
            type: "POST",
            url: serviceTypeWrapper.dataset.serviceTypeUrl,
            data: { product_category_id: pcID, area: area },
            dataType: "json",
            success: function (data) {
                if (!data.service_types || data.service_types.length === 0) {
                    if (chargeEl)
                        chargeEl.textContent = "No Service type found.";
                    return;
                }
                serviceTypeCache.set(cacheKey, data.service_types);
                populateServiceTypes(data.service_types);
                if (chargeEl) {
                    const currency = chargeEl.dataset.currency || "";
                    const label =
                        chargeEl.dataset.label || "Total Delivery Cost";
                    chargeEl.textContent = `${label} ${currency} 0.00`;
                }
            },
            error: function () {
                if (chargeEl) {
                    const currency = chargeEl.dataset.currency || "";
                    const label =
                        chargeEl.dataset.label || "Total Delivery Cost";
                    chargeEl.textContent = `${label} ${currency} 0.00`;
                }
            },
        });
    }

    function populateServiceTypes(serviceTypes) {
        const serviceTypeWrapper = form.querySelector(".service_type");
        const serviceTypeList = serviceTypeWrapper?.querySelector(".options");

        if (!serviceTypeWrapper || !serviceTypeList) return;

        serviceTypeList.innerHTML = "";

        for (const type of serviceTypes) {
            const li = document.createElement("li");
            li.setAttribute("data-id", type.id);
            li.textContent = type.name;
            serviceTypeList.appendChild(li);
        }
    }

    function getCharge() {
        pcID = form.querySelector("#product_category_input")?.value || "";
        stID = form.querySelector("#service_type_input")?.value || "";

        if (!pcID || !stID || !area) return;

        const chargeEl = form.querySelector(".charge");
        if (chargeEl) chargeEl.textContent = "Calculating Charge....";

        $.ajax({
            type: "POST",
            url: chargeEl?.dataset.url,
            data: {
                product_category_id: pcID,
                service_type_id: stID,
                area: area,
            },
            dataType: "json",
            success: function (data) {
                charge = parseFloat(data.charge) || 0;
                const currency = chargeEl?.dataset.currency || "";
                const label = chargeEl?.dataset.label || "Total Delivery Cost";
                if (chargeEl)
                    chargeEl.textContent = `${label} ${currency} ${charge.toFixed(
                        2
                    )}`;
            },
            error: function () {
                if (chargeEl)
                    chargeEl.textContent =
                        "No Charge Found with this combination.";
            },
        });
    }
}

document.addEventListener("DOMContentLoaded", () => {
    // BARANGAY  ADDRESS LOGIC
    try {
        const $barangaySelect = $("#barangay");
        const areaDetailsInput = document.getElementById("area_details");
        const eventAddressInput = document.getElementById("event_address");
        const form = document.getElementById("checkout_form");

        $barangaySelect.select2({
            placeholder: "Select Barangay",
            dropdownParent: $barangaySelect.parent(),
        });
        
        // ZC BARANGAY API GET
        fetch("https://psgc.cloud/api/cities/0931700000/barangays")
            .then((response) => response.json())
            .then((data) => {
                $barangaySelect
                    .empty()
                    .append(
                        "<option disabled selected>Select Barangay</option>"
                    );
                data.forEach((barangay) => {
                    $barangaySelect.append(
                        new Option(barangay.name, barangay.name)
                    );
                });
            })
            .catch((error) => {
                console.error("Error fetching barangays:", error);
                $barangaySelect.html(
                    '<option value="" disabled selected>Error loading barangays</option>'
                );
            });

        // COMBINE ADDRESS
        form?.addEventListener("submit", function () {
            const areaDetails = areaDetailsInput?.value.trim();
            const barangay = $barangaySelect.val();
            if (areaDetails && barangay) {
                eventAddressInput.value = `${areaDetails}, ${barangay}, Zamboanga City`;
            }
        });
    } catch (error) {
        console.error("Error in address logic:", error);
    }

    // EVENT TYPE HANDLING hide show
    try {
        const eventTypeSelect = document.getElementById("event_type_select");
        const customEventContainer = document.getElementById(
            "custom_event_type_container"
        );

        if (eventTypeSelect && customEventContainer) {
            eventTypeSelect.addEventListener("change", function () {
                const isOther = this.value === "Other";
                customEventContainer.style.display = isOther ? "block" : "none";
                const customEventInput =
                    document.getElementById("custom_event_type");
                if (customEventInput) {
                    customEventInput.value = isOther
                        ? customEventInput.value
                        : "";
                    customEventInput.required = isOther;
                }
            });
        }
    } catch (error) {
        console.error("Error in event type logic:", error);
    }

    // TIME SLOT + VALIDATION
    try {
        let eventDate =
            document.querySelector('input[name="event_date"]')?.value ||
            "{{ $eventDate }}";
        let availableSlots = [];

        const elements = {
            timeModeInput: document.getElementById("time_mode_input"),
            defaultTimeSlotsSection: document
                .getElementById("event_time_slots")
                ?.closest(".space-y-2"),
            customTimeWrapper: document.getElementById("custom_time_wrapper"),
            customTimeSlots: document.getElementById("custom_time_slots"),
            requestCustomTimeBtn: document.getElementById(
                "request_custom_time"
            ),
            backToDefaultSlotsBtn: document.getElementById(
                "back_to_default_slots"
            ),
            eventTimeRadios: () =>
                document.querySelectorAll('input[name="event_time_slot"]'),
            customTimeRadios: () =>
                document.querySelectorAll('input[name="custom_time_slot"]'),
            submitButton: document.querySelector('form button[type="submit"]'),
            timeSlotError: document.getElementById("time-slot-error"),
            customTimeError: document.getElementById("time-error"),
        };

        const fetchAvailableSlots = async () => {
            try {
                const response = await fetch(
                    `/bookings/available-slots?event_date=${encodeURIComponent(
                        eventDate
                    )}`,
                    {
                        headers: {
                            Accept: "application/json",
                            "X-Requested-With": "XMLHttpRequest",
                            "X-CSRF-TOKEN": document.querySelector(
                                'meta[name="csrf-token"]'
                            ).content,
                        },
                    }
                );

                if (!response.ok)
                    throw new Error("Failed to fetch available slots");

                availableSlots = await response.json();
                renderCustomTimeSlots();
            } catch (error) {
                showError(
                    elements.customTimeError,
                    "Unable to load time slots. Please try again."
                );
                console.error(error);
            }
        };

        const renderCustomTimeSlots = () => {
            elements.customTimeSlots.innerHTML = "";

            if (availableSlots.length === 0) {
                showError(
                    elements.customTimeError,
                    "All time slots are booked for this date."
                );
                elements.customTimeSlots.innerHTML =
                    '<p class="text-gray-500">No available time slots.</p>';
                return;
            }

            availableSlots.forEach((slot, index) => {
                const slotId = `custom_time_slot_${index}`;
                elements.customTimeSlots.insertAdjacentHTML(
                    "beforeend",
                    `
                    <div class="flex items-center">
                        <input type="radio" name="custom_time_slot" id="${slotId}" value="${
                        slot.start
                    }|${slot.end}" class="mr-2 focus:ring-blue-500">
                        <label for="${slotId}" class="text-gray-700">${formatTime(
                        slot.start
                    )}-${formatTime(slot.end)}</label>
                    </div>
                `
                );
            });

            elements.customTimeRadios().forEach((radio) => {
                radio.addEventListener("change", validateCustomTime);
            });
        };

        const formatTime = (time) => {
            const [hours, minutes] = time.split(":").map(Number);
            const date = new Date(1970, 0, 1, hours, minutes);
            const h = date.getHours() % 12 || 12;
            const m = date.getMinutes().toString().padStart(2, "0");
            const ampm = date.getHours() >= 12 ? "PM" : "AM";
            return `${h}:${m}${ampm}`;
        };

        const toggleTimeMode = (mode) => {
            elements.timeModeInput.value = mode;

            if (mode === "slot") {
                elements.defaultTimeSlotsSection.style.display = "block";
                elements.customTimeWrapper.style.display = "none";
                elements.requestCustomTimeBtn.style.display = "flex";
                setRequiredAttributes(elements.eventTimeRadios(), true);
                setRequiredAttributes(elements.customTimeRadios(), false);
                validateEventTimeSlot();
            } else {
                elements.defaultTimeSlotsSection.style.display = "none";
                elements.customTimeWrapper.style.display = "grid";
                elements.requestCustomTimeBtn.style.display = "none";
                setRequiredAttributes(elements.eventTimeRadios(), false);
                setRequiredAttributes(elements.customTimeRadios(), true);
                validateCustomTime();
            }
        };

        const setRequiredAttributes = (inputs, required) => {
            inputs.forEach((input) => {
                if (required) input.setAttribute("required", "required");
                else input.removeAttribute("required");
            });
        };

        const validateSelection = (inputName, errorElement, mode) => {
            const selected = document.querySelector(
                `input[name="${inputName}"]:checked`
            );
            const currentMode = elements.timeModeInput.value;

            if (!selected && currentMode === mode) {
                showError(errorElement, "Please select a time slot.");
                if (elements.submitButton)
                    elements.submitButton.disabled = true;
                return false;
            }

            hideError(errorElement);
            if (elements.submitButton) elements.submitButton.disabled = false;
            return true;
        };

        const validateEventTimeSlot = () =>
            validateSelection(
                "event_time_slot",
                elements.timeSlotError,
                "slot"
            );
        const validateCustomTime = () =>
            validateSelection(
                "custom_time_slot",
                elements.customTimeError,
                "custom"
            );

        const showError = (element, message) => {
            if (element) {
                element.textContent = message;
                element.classList.remove("hidden");
            }
        };

        const hideError = (element) => {
            if (element) {
                element.textContent = "";
                element.classList.add("hidden");
            }
        };

        const handleEventDateChange = () => {
            const eventDateInput = document.querySelector(
                'input[name="event_date"]'
            );
            eventDateInput?.addEventListener("change", (e) => {
                eventDate = e.target.value;
                fetchAvailableSlots();
                validateEventTimeSlot();
                validateCustomTime();
            });
        };

        const bindListeners = () => {
            elements.requestCustomTimeBtn?.addEventListener("click", () =>
                toggleTimeMode("custom")
            );
            elements.backToDefaultSlotsBtn?.addEventListener("click", () =>
                toggleTimeMode("slot")
            );

            elements
                .eventTimeRadios()
                .forEach((radio) =>
                    radio.addEventListener("change", validateEventTimeSlot)
                );
            handleEventDateChange();
        };

        fetchAvailableSlots();
        bindListeners();

    } catch (error) {
        console.error("Error in time slot logic:", error);
    }
});

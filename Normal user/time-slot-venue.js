(function () {
    var citySwitch = document.getElementById("citySwitch");
    var cityButtons = citySwitch ? Array.prototype.slice.call(citySwitch.querySelectorAll(".city-pill")) : [];
    var venueCards = Array.prototype.slice.call(document.querySelectorAll(".venue-card"));
    var showDate = document.getElementById("showDate");
    var continueBtn = document.getElementById("continueBtn");
    var selectedShowLabel = document.getElementById("selectedShowLabel");
    var summaryShow = document.getElementById("summaryShow");
    var summaryCity = document.getElementById("summaryCity");
    var summaryVenue = document.getElementById("summaryVenue");
    var summaryScreen = document.getElementById("summaryScreen");
    var summaryTime = document.getElementById("summaryTime");
    var summaryDate = document.getElementById("summaryDate");
    var selectedShowInput = document.getElementById("selectedShowInput");
    var selectedVenueInput = document.getElementById("selectedVenueInput");
    var selectedTimeInput = document.getElementById("selectedTimeInput");
    var selectedCityInput = document.getElementById("selectedCityInput");

    var selectedCity = selectedCityInput ? selectedCityInput.value || "Ahmedabad" : "Ahmedabad";
    var selectedVenue = "";
    var selectedTime = "";
    var selectedScreen = "";
    var selectedShow = selectedShowInput ? selectedShowInput.value || "Kung Fu Panda" : "Kung Fu Panda";

    function parseParams() {
        return new URLSearchParams(window.location.search);
    }

    function getTodayString() {
        return new Date().toISOString().slice(0, 10);
    }

    function getSafeBookingDate(value) {
        var today = getTodayString();
        if (!value || value < today) return today;
        return value;
    }

    function setDefaultDate() {
        if (!showDate) return;
        var today = getTodayString();
        showDate.min = today;
        if (!showDate.value || showDate.value < today) {
            showDate.value = today;
        }
    }

    function setShowFromQuery() {
        var params = parseParams();
        var queryShow = params.get("show");
        var queryDate = params.get("date");
        var queryCity = params.get("city");

        if (queryShow) selectedShow = queryShow;
        if (showDate) showDate.value = getSafeBookingDate(queryDate || showDate.value);
        if (queryCity) selectedCity = queryCity;
    }

    function updateHiddenInputs() {
        if (selectedShowInput) selectedShowInput.value = selectedShow;
        if (selectedVenueInput) selectedVenueInput.value = selectedVenue;
        if (selectedTimeInput) selectedTimeInput.value = selectedTime;
        if (selectedCityInput) selectedCityInput.value = selectedCity;
    }

    function updateCityState() {
        var hasVisibleCard = false;

        cityButtons.forEach(function (button) {
            var active = button.getAttribute("data-city") === selectedCity;
            button.classList.toggle("active", active);
        });

        venueCards.forEach(function (card) {
            var matches = card.getAttribute("data-city") === selectedCity;
            card.classList.toggle("hidden", !matches);
            if (matches) {
                hasVisibleCard = true;
            }
        });

        if (!hasVisibleCard && cityButtons[0]) {
            selectedCity = cityButtons[0].getAttribute("data-city") || selectedCity;
            updateCityState();
        }
    }

    function clearTimesForCity() {
        venueCards.forEach(function (card) {
            var times = card.querySelectorAll(".time-btn");
            times.forEach(function (button) {
                button.classList.remove("active");
            });
        });
        selectedVenue = "";
        selectedTime = "";
        selectedScreen = "";
        updateHiddenInputs();
    }

    function updateSummary() {
        if (summaryShow) summaryShow.textContent = selectedShow;
        if (summaryCity) summaryCity.textContent = "City: " + (selectedCity || "Not selected");
        if (summaryVenue) summaryVenue.textContent = "Venue: " + (selectedVenue || "Not selected");
        if (summaryScreen) summaryScreen.textContent = "Screen: " + (selectedScreen || "Not selected");
        if (summaryTime) summaryTime.textContent = "Time: " + (selectedTime || "Not selected");
        if (summaryDate) summaryDate.textContent = "Date: " + ((showDate && showDate.value) || "Not selected");
        if (selectedShowLabel) selectedShowLabel.textContent = "Now booking: " + selectedShow;
        if (continueBtn) continueBtn.disabled = !(selectedVenue && selectedTime && showDate && showDate.value);
        updateHiddenInputs();
    }

    cityButtons.forEach(function (button) {
        button.addEventListener("click", function () {
            selectedCity = button.getAttribute("data-city");
            clearTimesForCity();
            updateCityState();
            updateSummary();
        });
    });

    venueCards.forEach(function (card) {
        var timeButtons = card.querySelectorAll(".time-btn");
        timeButtons.forEach(function (button) {
            button.addEventListener("click", function () {
                if (card.getAttribute("data-city") !== selectedCity) return;

                clearTimesForCity();
                button.classList.add("active");
                selectedVenue = card.getAttribute("data-venue") || card.querySelector(".venue-head h3").textContent.trim();
                selectedTime = button.getAttribute("data-time") || "";
                selectedScreen = button.getAttribute("data-screen") || "";
                updateSummary();
            });
        });
    });

    if (showDate) {
        showDate.addEventListener("change", function () {
            showDate.value = getSafeBookingDate(showDate.value);
            updateSummary();
        });
    }

    setDefaultDate();
    setShowFromQuery();
    updateCityState();
    updateSummary();
})();

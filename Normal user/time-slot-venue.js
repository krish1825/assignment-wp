(function () {
    var citySwitch = document.getElementById("citySwitch");
    var cityButtons = Array.prototype.slice.call(citySwitch.querySelectorAll(".city-pill"));
    var venueCards = Array.prototype.slice.call(document.querySelectorAll(".venue-card"));
    var showDate = document.getElementById("showDate");
    var continueBtn = document.getElementById("continueBtn");
    var selectedShowLabel = document.getElementById("selectedShowLabel");
    var summaryShow = document.getElementById("summaryShow");
    var summaryVenue = document.getElementById("summaryVenue");
    var summaryTime = document.getElementById("summaryTime");
    var summaryDate = document.getElementById("summaryDate");

    var selectedCity = "Ahmedabad";
    var selectedVenue = "";
    var selectedTime = "";
    var selectedShow = "Kung Fu Panda (Hindi 2D)";

    function parseParams() {
        return new URLSearchParams(window.location.search);
    }

    function setDefaultDate() {
        var today = new Date().toISOString().slice(0, 10);
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
        if (queryDate) showDate.value = queryDate;
        if (queryCity) selectedCity = queryCity;
    }

    function updateCityState() {
        cityButtons.forEach(function (button) {
            var active = button.getAttribute("data-city") === selectedCity;
            button.classList.toggle("active", active);
        });

        venueCards.forEach(function (card) {
            var matches = card.getAttribute("data-city") === selectedCity;
            card.classList.toggle("hidden", !matches);
        });
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
    }

    function updateSummary() {
        summaryShow.textContent = selectedShow;
        summaryVenue.textContent = "Venue: " + (selectedVenue || "Not selected");
        summaryTime.textContent = "Time: " + (selectedTime || "Not selected");
        summaryDate.textContent = "Date: " + (showDate.value || "Not selected");
        selectedShowLabel.textContent = "Now booking: " + selectedShow;
        continueBtn.disabled = !(selectedVenue && selectedTime && showDate.value);
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
                selectedVenue = card.querySelector(".venue-head h3").textContent.trim();
                selectedTime = button.getAttribute("data-time");
                updateSummary();
            });
        });
    });

    showDate.addEventListener("change", updateSummary);

    continueBtn.addEventListener("click", function () {
        if (continueBtn.disabled) return;
        var url = "seat-booking.php?show=" + encodeURIComponent(selectedShow) +
            "&date=" + encodeURIComponent(showDate.value) +
            "&time=" + encodeURIComponent(selectedTime) +
            "&venue=" + encodeURIComponent(selectedVenue) +
            "&city=" + encodeURIComponent(selectedCity);
        window.location.href = url;
    });

    setDefaultDate();
    setShowFromQuery();
    updateCityState();
    updateSummary();
})();

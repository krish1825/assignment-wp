(function () {
    var maxSeats = 8;
    var seats = Array.prototype.slice.call(document.querySelectorAll(".seat:not(.occupied)"));
    var showSelect = document.getElementById("showSelect");
    var showDate = document.getElementById("showDate");
    var showTime = document.getElementById("showTime");
    var payBtn = document.getElementById("payBtn");
    var clearSelectionBtn = document.getElementById("clearSelectionBtn");
    var selectionHint = document.getElementById("selectionHint");
    var holdTimer = document.getElementById("holdTimer");

    var summaryShow = document.getElementById("summaryShow");
    var summaryDate = document.getElementById("summaryDate");
    var summaryTime = document.getElementById("summaryTime");
    var summarySeats = document.getElementById("summarySeats");
    var summaryCount = document.getElementById("summaryCount");
    var summarySubtotal = document.getElementById("summarySubtotal");
    var summaryFee = document.getElementById("summaryFee");
    var summaryTotal = document.getElementById("summaryTotal");
    var holdSeconds = 10 * 60;
    var selectedVenue = "-";

    function formatINR(amount) {
        return "INR " + amount.toLocaleString("en-IN");
    }

    function getSelectedSeats() {
        return seats.filter(function (seat) {
            return seat.classList.contains("selected");
        });
    }

    function parseQuery() {
        return new URLSearchParams(window.location.search);
    }

    function applyShowFromQuery(value) {
        if (!value) return;
        var normalized = value.toLowerCase();
        var found = Array.prototype.find.call(showSelect.options, function (option) {
            return option.value.toLowerCase() === normalized;
        });

        if (found) {
            showSelect.value = found.value;
            return;
        }

        var option = document.createElement("option");
        option.value = value;
        option.textContent = value;
        option.selected = true;
        showSelect.appendChild(option);
    }

    function applyInitialFilters() {
        var params = parseQuery();
        var queryShow = params.get("show");
        var queryDate = params.get("date");
        var queryTime = params.get("time");
        var queryVenue = params.get("venue");
        var today = new Date().toISOString().slice(0, 10);

        showDate.min = today;
        if (!showDate.value || showDate.value < today) {
            showDate.value = today;
        }

        applyShowFromQuery(queryShow || "");
        if (queryDate) showDate.value = queryDate;

        if (queryTime) {
            var matchedTime = Array.prototype.find.call(showTime.options, function (option) {
                return option.value === queryTime;
            });
            if (matchedTime) {
                showTime.value = matchedTime.value;
            } else {
                var timeOption = document.createElement("option");
                timeOption.value = queryTime;
                timeOption.textContent = queryTime;
                timeOption.selected = true;
                showTime.appendChild(timeOption);
            }
        }

        if (queryVenue) selectedVenue = queryVenue;
    }

    function updateHoldTimer() {
        var minutes = Math.floor(holdSeconds / 60);
        var seconds = holdSeconds % 60;
        holdTimer.textContent = String(minutes).padStart(2, "0") + ":" + String(seconds).padStart(2, "0");
        if (holdSeconds > 0) holdSeconds--;
    }

    function updateSummary() {
        var selected = getSelectedSeats();
        var seatNames = selected
            .map(function (seat) { return seat.getAttribute("data-seat"); })
            .sort();

        var subtotal = selected.reduce(function (sum, seat) {
            return sum + Number(seat.getAttribute("data-price") || 0);
        }, 0);

        var convenienceFee = selected.length ? 49 : 0;
        var total = subtotal + convenienceFee;

        summaryShow.textContent = showSelect.value;
        summaryDate.textContent = showDate.value || "-";
        summaryTime.textContent = showTime.value;
        summarySeats.textContent = seatNames.length ? seatNames.join(", ") : "None selected";
        summaryCount.textContent = String(selected.length);
        summarySubtotal.textContent = formatINR(subtotal);
        summaryFee.textContent = formatINR(convenienceFee);
        summaryTotal.textContent = formatINR(total);
        payBtn.disabled = selected.length === 0;
        clearSelectionBtn.disabled = selected.length === 0;
        selectionHint.textContent = selected.length
            ? (selected.length + " seat(s) selected. " + (maxSeats - selected.length) + " left.")
            : ("Pick up to " + maxSeats + " seats.");
    }

    seats.forEach(function (seat) {
        seat.addEventListener("click", function () {
            var selected = getSelectedSeats();
            var isSelected = seat.classList.contains("selected");
            if (!isSelected && selected.length >= maxSeats) {
                selectionHint.textContent = "Maximum " + maxSeats + " seats allowed per booking.";
                return;
            }
            seat.classList.toggle("selected");
            updateSummary();
        });
    });

    [showSelect, showDate, showTime].forEach(function (control) {
        control.addEventListener("change", updateSummary);
    });

    clearSelectionBtn.addEventListener("click", function () {
        seats.forEach(function (seat) {
            seat.classList.remove("selected");
        });
        updateSummary();
    });

    payBtn.addEventListener("click", function () {
        var selectedSeats = getSelectedSeats().map(function (seat) {
            return seat.getAttribute("data-seat");
        });
        if (!selectedSeats.length) return;
        var subtotal = getSelectedSeats().reduce(function (sum, seat) {
            return sum + Number(seat.getAttribute("data-price") || 0);
        }, 0);
        var fee = selectedSeats.length ? 49 : 0;
        var total = subtotal + fee;

        var url = "payment.php?show=" + encodeURIComponent(showSelect.value) +
            "&date=" + encodeURIComponent(showDate.value) +
            "&time=" + encodeURIComponent(showTime.value) +
            "&venue=" + encodeURIComponent(selectedVenue) +
            "&seats=" + encodeURIComponent(selectedSeats.join(", ")) +
            "&subtotal=" + encodeURIComponent(String(subtotal)) +
            "&fee=" + encodeURIComponent(String(fee)) +
            "&total=" + encodeURIComponent(String(total));
        window.location.href = url;
    });

    applyInitialFilters();
    updateHoldTimer();
    setInterval(updateHoldTimer, 1000);
    updateSummary();
})();

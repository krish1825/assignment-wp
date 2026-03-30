(function () {
    var maxSeatsAllowed = 8;
    var targetCount = 2;
    var seats = Array.prototype.slice.call(document.querySelectorAll('.seat:not(.occupied)'));
    var payBtn = document.getElementById('payBtn');
    var clearSelectionBtn = document.getElementById('clearSelectionBtn');
    var selectionHint = document.getElementById('selectionHint');
    var selectionBadge = document.getElementById('selectionBadge');
    var holdTimer = document.getElementById('holdTimer');
    var summarySeats = document.getElementById('summarySeats');
    var summaryCount = document.getElementById('summaryCount');
    var summarySubtotal = document.getElementById('summarySubtotal');
    var summaryFee = document.getElementById('summaryFee');
    var summaryTotal = document.getElementById('summaryTotal');
    var selectedSeatChips = document.getElementById('selectedSeatChips');
    var targetSeatCount = document.getElementById('targetSeatCount');
    var seatCountModal = document.getElementById('seatCountModal');
    var countButtons = Array.prototype.slice.call(document.querySelectorAll('.count-btn'));
    var startSelectionBtn = document.getElementById('startSelectionBtn');
    var holdSeconds = 10 * 60;
    var paymentSeatsInput = document.getElementById('paymentSeatsInput');
    var paymentSubtotalInput = document.getElementById('paymentSubtotalInput');
    var paymentFeeInput = document.getElementById('paymentFeeInput');
    var paymentTotalInput = document.getElementById('paymentTotalInput');

    function formatINR(amount) {
        return 'INR ' + amount.toLocaleString('en-IN');
    }

    function getSelectedSeats() {
        return seats.filter(function (seat) {
            return seat.classList.contains('selected');
        });
    }

    function updateHoldTimer() {
        var minutes = Math.floor(holdSeconds / 60);
        var seconds = holdSeconds % 60;
        if (holdTimer) {
            holdTimer.textContent = String(minutes).padStart(2, '0') + ':' + String(seconds).padStart(2, '0');
        }
        if (holdSeconds > 0) {
            holdSeconds--;
        }
    }

    function updatePaymentInputs(seatNames, subtotal, convenienceFee, total) {
        if (paymentSeatsInput) paymentSeatsInput.value = seatNames.join(', ');
        if (paymentSubtotalInput) paymentSubtotalInput.value = String(subtotal);
        if (paymentFeeInput) paymentFeeInput.value = String(convenienceFee);
        if (paymentTotalInput) paymentTotalInput.value = String(total);
    }

    function renderSeatChips(selected) {
        if (!selectedSeatChips) return;
        if (!selected.length) {
            selectedSeatChips.innerHTML = '';
            return;
        }

        selectedSeatChips.innerHTML = selected.map(function (seat) {
            var label = seat.getAttribute('data-seat') || '';
            var band = seat.getAttribute('data-band') || '';
            return '<span class="seat-chip">' + label + ' <small>' + band + '</small></span>';
        }).join('');
    }

    function updateSummary() {
        var selected = getSelectedSeats().sort(function (a, b) {
            return (a.getAttribute('data-seat') || '').localeCompare(b.getAttribute('data-seat') || '');
        });
        var seatNames = selected.map(function (seat) { return seat.getAttribute('data-seat'); });
        var subtotal = selected.reduce(function (sum, seat) {
            return sum + Number(seat.getAttribute('data-price') || 0);
        }, 0);
        var convenienceFee = selected.length ? 59 : 0;
        var total = subtotal + convenienceFee;

        if (summarySeats) summarySeats.textContent = seatNames.length ? seatNames.join(', ') : 'None selected';
        if (summaryCount) summaryCount.textContent = String(selected.length);
        if (summarySubtotal) summarySubtotal.textContent = formatINR(subtotal);
        if (summaryFee) summaryFee.textContent = formatINR(convenienceFee);
        if (summaryTotal) summaryTotal.textContent = formatINR(total);
        if (selectionBadge) selectionBadge.textContent = selected.length + ' of ' + targetCount + ' selected';
        if (targetSeatCount) targetSeatCount.textContent = String(targetCount);
        if (payBtn) payBtn.disabled = selected.length !== targetCount;
        if (clearSelectionBtn) clearSelectionBtn.disabled = selected.length === 0;

        if (selectionHint) {
            if (!selected.length) {
                selectionHint.textContent = 'Choose exactly ' + targetCount + ' seat' + (targetCount > 1 ? 's' : '') + ' to continue.';
            } else if (selected.length < targetCount) {
                selectionHint.textContent = 'Add ' + (targetCount - selected.length) + ' more seat' + (targetCount - selected.length > 1 ? 's' : '') + ' to match your ticket count.';
            } else {
                selectionHint.textContent = 'Perfect. Your selected seats are ready for checkout.';
            }
        }

        renderSeatChips(selected);
        updatePaymentInputs(seatNames, subtotal, convenienceFee, total);
    }

    function clearSelections() {
        seats.forEach(function (seat) {
            seat.classList.remove('selected');
        });
    }

    function isCoupleSeat(seat) {
        return seat.getAttribute('data-couple') === 'true';
    }

    function toggleSeat(seat) {
        var selected = getSelectedSeats();
        var isSelected = seat.classList.contains('selected');

        if (!isSelected && selected.length >= Math.min(targetCount, maxSeatsAllowed)) {
            if (selectionHint) {
                selectionHint.textContent = 'You selected the ticket count already. Clear one seat to change.';
            }
            return;
        }

        if (isCoupleSeat(seat) && targetCount === 1 && !isSelected) {
            if (selectionHint) {
                selectionHint.textContent = 'Couple seats are best booked in pairs. Increase ticket count to 2 or more.';
            }
            return;
        }

        seat.classList.toggle('selected');
        updateSummary();
    }

    seats.forEach(function (seat) {
        seat.addEventListener('click', function () {
            toggleSeat(seat);
        });
    });

    if (clearSelectionBtn) {
        clearSelectionBtn.addEventListener('click', function () {
            clearSelections();
            updateSummary();
        });
    }

    countButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            countButtons.forEach(function (btn) {
                btn.classList.toggle('active', btn === button);
            });
            targetCount = Number(button.getAttribute('data-count') || 2);
            if (targetSeatCount) targetSeatCount.textContent = String(targetCount);
            clearSelections();
            updateSummary();
        });
    });

    if (startSelectionBtn) {
        startSelectionBtn.addEventListener('click', function () {
            if (seatCountModal) {
                seatCountModal.classList.remove('active');
            }
            updateSummary();
        });
    }

    updateHoldTimer();
    setInterval(updateHoldTimer, 1000);
    updateSummary();
})();

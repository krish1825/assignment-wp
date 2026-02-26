(function () {
    var methodTabs = Array.prototype.slice.call(document.querySelectorAll(".method-tab"));
    var methodPanels = Array.prototype.slice.call(document.querySelectorAll(".method-panel"));
    var paymentForm = document.getElementById("paymentForm");
    var paymentErrors = document.getElementById("paymentErrors");
    var activeMethod = "card";

    var sumShow = document.getElementById("sumShow");
    var sumDate = document.getElementById("sumDate");
    var sumTime = document.getElementById("sumTime");
    var sumVenue = document.getElementById("sumVenue");
    var sumSeats = document.getElementById("sumSeats");
    var sumSubtotal = document.getElementById("sumSubtotal");
    var sumFee = document.getElementById("sumFee");
    var sumTotal = document.getElementById("sumTotal");

    function getParams() {
        return new URLSearchParams(window.location.search);
    }

    function formatINR(amount) {
        return "INR " + amount.toLocaleString("en-IN");
    }

    function fillSummary() {
        var params = getParams();
        var subtotal = Number(params.get("subtotal") || 0);
        var fee = Number(params.get("fee") || 0);
        var total = Number(params.get("total") || 0);

        sumShow.textContent = params.get("show") || "-";
        sumDate.textContent = params.get("date") || "-";
        sumTime.textContent = params.get("time") || "-";
        sumVenue.textContent = params.get("venue") || "-";
        sumSeats.textContent = params.get("seats") || "-";
        sumSubtotal.textContent = formatINR(subtotal);
        sumFee.textContent = formatINR(fee);
        sumTotal.textContent = formatINR(total);
    }

    function switchMethod(method) {
        activeMethod = method;
        methodTabs.forEach(function (tab) {
            tab.classList.toggle("active", tab.getAttribute("data-method") === method);
        });
        methodPanels.forEach(function (panel) {
            panel.classList.toggle("active", panel.getAttribute("data-panel") === method);
        });
        paymentErrors.style.display = "none";
        paymentErrors.textContent = "";
    }

    methodTabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            switchMethod(tab.getAttribute("data-method"));
        });
    });

    paymentForm.addEventListener("submit", function (e) {
        e.preventDefault();
        var errors = [];

        if (activeMethod === "card") {
            var cardNumber = paymentForm.card_number.value.replace(/\s+/g, "");
            var cardName = paymentForm.card_name.value.trim();
            var cardExpiry = paymentForm.card_expiry.value.trim();
            var cardCvv = paymentForm.card_cvv.value.trim();

            if (!/^\d{16}$/.test(cardNumber)) errors.push("Enter a valid 16-digit card number.");
            if (!cardName) errors.push("Cardholder name is required.");
            if (!/^(0[1-9]|1[0-2])\/\d{2}$/.test(cardExpiry)) errors.push("Enter expiry in MM/YY format.");
            if (!/^\d{3}$/.test(cardCvv)) errors.push("Enter a valid 3-digit CVV.");
        }

        if (activeMethod === "upi") {
            var upi = paymentForm.upi_id.value.trim();
            if (!/^[\w.\-]{2,}@[a-zA-Z]{2,}$/.test(upi)) errors.push("Enter a valid UPI ID.");
        }

        if (activeMethod === "netbanking" && !paymentForm.bank_name.value) {
            errors.push("Select a bank to continue.");
        }

        if (activeMethod === "wallet" && !paymentForm.wallet_name.value) {
            errors.push("Select a wallet to continue.");
        }

        if (errors.length) {
            paymentErrors.innerHTML = errors.join("<br>");
            paymentErrors.style.display = "block";
            return;
        }

        alert("Payment successful. Your tickets are confirmed.");
        window.location.href = "My_Bookings.php";
    });

    fillSummary();
    switchMethod("card");
})();

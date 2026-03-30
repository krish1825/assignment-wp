(function () {
    var methodTabs = Array.prototype.slice.call(document.querySelectorAll(".method-tab"));
    var methodPanels = Array.prototype.slice.call(document.querySelectorAll(".method-panel"));
    var paymentForm = document.getElementById("paymentForm");
    var paymentErrors = document.getElementById("paymentErrors");
    var paymentMethodInput = document.getElementById("paymentMethodInput");
    var activeMethod = "card";

    function switchMethod(method) {
        activeMethod = method;
        if (paymentMethodInput) paymentMethodInput.value = method;
        methodTabs.forEach(function (tab) {
            tab.classList.toggle("active", tab.getAttribute("data-method") === method);
        });
        methodPanels.forEach(function (panel) {
            panel.classList.toggle("active", panel.getAttribute("data-panel") === method);
        });
        if (paymentErrors) {
            paymentErrors.style.display = "none";
            paymentErrors.textContent = "";
        }
    }

    methodTabs.forEach(function (tab) {
        tab.addEventListener("click", function () {
            switchMethod(tab.getAttribute("data-method"));
        });
    });

    if (paymentForm) {
        paymentForm.addEventListener("submit", function (e) {
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
            if (activeMethod === "netbanking" && !paymentForm.bank_name.value) errors.push("Select a bank to continue.");
            if (activeMethod === "wallet" && !paymentForm.wallet_name.value) errors.push("Select a wallet to continue.");
            if (errors.length) {
                e.preventDefault();
                paymentErrors.innerHTML = errors.join("<br>");
                paymentErrors.style.display = "block";
                return;
            }
            if (paymentMethodInput) paymentMethodInput.value = activeMethod;
        });
    }

    switchMethod("card");
})();

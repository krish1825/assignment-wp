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
        paymentForm.addEventListener("submit", function () {
            if (paymentMethodInput) paymentMethodInput.value = activeMethod;
        });
    }

    switchMethod("card");
})();

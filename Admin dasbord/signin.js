$(function () {
    function setError($field, message) {
        $field.addClass("has-error");
        $field.next(".error-message").text(message);
    }

    function clearError($field) {
        $field.removeClass("has-error");
        $field.next(".error-message").text("");
    }

    function validateEmail() {
        var $field = $("#admin_email");
        var value = $.trim($field.val());
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

        if (!emailPattern.test(value)) {
            setError($field, "Enter a valid email address.");
            return false;
        }

        clearError($field);
        return true;
    }

    function validatePassword() {
        var $field = $("#admin_password");
        var value = $.trim($field.val());

        if (value.length < 6) {
            setError($field, "Password must be at least 6 characters.");
            return false;
        }

        clearError($field);
        return true;
    }

    $("#admin_email").on("input blur", validateEmail);
    $("#admin_password").on("input blur", validatePassword);

    $("#adminSignInForm").on("submit", function (event) {
        var isValid = validateEmail() && validatePassword();
        if (!isValid) {
            event.preventDefault();
        }
    });

    $(".social-login .google").on("click", function () {
        window.location.href = "https://accounts.google.com/AccountChooser";
    });

    $(".social-login .facebook").on("click", function () {
        window.open("https://www.facebook.com/login", "_blank");
    });
});


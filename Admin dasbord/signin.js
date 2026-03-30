<<<<<<< HEAD
function googleLogin() {
    window.location.href = "https://accounts.google.com/AccountChooser";
}

function facebookLogin() {
    window.open("https://www.facebook.com/login", "_blank");
}

document.addEventListener("DOMContentLoaded", function () {
    var googleBtn = document.querySelector(".social-login .google");
    var facebookBtn = document.querySelector(".social-login .facebook");
    var form = document.getElementById("loginForm");
    var errorBox = document.getElementById("loginErrors");

    if (googleBtn) {
        googleBtn.addEventListener("click", googleLogin);
=======
$(function () {
    function setError($field, message) {
        $field.addClass("has-error");
        $field.next(".error-message").text(message);
>>>>>>> 38d872e849e51c68b1bbb737b8fc11198aaccacf
    }

    function clearError($field) {
        $field.removeClass("has-error");
        $field.next(".error-message").text("");
    }

<<<<<<< HEAD
    if (form && errorBox) {
        form.addEventListener("submit", function (event) {
            var errors = [];
            var userIdInput = form.querySelector("[name='user_id']");
            var passwordInput = form.querySelector("[name='password']");
            var userId = userIdInput ? userIdInput.value.trim() : "";
            var password = passwordInput ? passwordInput.value : "";

            if (userIdInput) {
                userIdInput.classList.remove("field-error");
            }
            if (passwordInput) {
                passwordInput.classList.remove("field-error");
            }

            if (!userId) {
                errors.push("User ID is required.");
                if (userIdInput) {
                    userIdInput.classList.add("field-error");
                }
            }

            if (!password) {
                errors.push("Password is required.");
                if (passwordInput) {
                    passwordInput.classList.add("field-error");
                }
            }

            if (errors.length) {
                event.preventDefault();
                errorBox.innerHTML = errors.join("<br>");
                errorBox.style.display = "block";
            } else {
                errorBox.innerHTML = "";
                errorBox.style.display = "none";
            }
        });
    }
=======
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
>>>>>>> 38d872e849e51c68b1bbb737b8fc11198aaccacf
});


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
    }

    if (facebookBtn) {
        facebookBtn.addEventListener("click", facebookLogin);
    }

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
});


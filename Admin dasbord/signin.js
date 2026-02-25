function googleLogin() {
    window.location.href = "https://accounts.google.com/AccountChooser";
}

function facebookLogin() {
    window.open("https://www.facebook.com/login", "_blank");
}

document.addEventListener("DOMContentLoaded", function () {
    var googleBtn = document.querySelector(".social-login .google");
    var facebookBtn = document.querySelector(".social-login .facebook");

    if (googleBtn) {
        googleBtn.addEventListener("click", googleLogin);
    }

    if (facebookBtn) {
        facebookBtn.addEventListener("click", facebookLogin);
    }
});


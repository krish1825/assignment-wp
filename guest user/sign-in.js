function googleLogin() {
    window.location.href = "https://accounts.google.com/AccountChooser";
}

function facebookLogin() {
    window.open("https://www.facebook.com/login", "_blank");
}

$(function () {
    var $form = $("#loginForm");
    var $errorBox = $("#loginErrors");

    $form.on("submit", function (e) {
        var errors = [];

        $form.find("input").removeClass("field-error");
        $errorBox.hide().empty();

        var email = $.trim($form.find("[name='email']").val());
        var password = $form.find("[name='password']").val();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!email || !emailRegex.test(email)) {
            errors.push("Enter a valid Email address.");
            $form.find("[name='email']").addClass("field-error");
        }

        if (!password) {
            errors.push("Password is required.");
            $form.find("[name='password']").addClass("field-error");
        }

        if (errors.length) {
            e.preventDefault();
            $errorBox.html(errors.join("<br>")).show();
        }
    });
});

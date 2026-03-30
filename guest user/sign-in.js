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

        var userId = $.trim($form.find("[name='user_id']").val());
        var password = $form.find("[name='password']").val();

        if (!userId) {
            errors.push("User ID is required.");
            $form.find("[name='user_id']").addClass("field-error");
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

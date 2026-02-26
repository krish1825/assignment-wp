$(function () {
    var $form = $("#registrationForm");
    var $errorBox = $("#formErrors");

    function showErrors(errors) {
        $errorBox.html(errors.join("<br>"));
        $errorBox.show();
    }

    $form.on("submit", function (e) {
        var errors = [];

        $form.find("input, select, textarea").removeClass("field-error");
        $errorBox.hide().empty();

        var fullname = $.trim($form.find("[name='fullname']").val());
        var email = $.trim($form.find("[name='email']").val());
        var phone = $.trim($form.find("[name='phoneno']").val());
        var username = $.trim($form.find("[name='username']").val());
        var password = $form.find("[name='password']").val();
        var confirmPassword = $form.find("[name='confirm_password']").val();
        var gender = $form.find("[name='gender']:checked").val();

        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        if (!fullname) {
            errors.push("Full Name is required.");
            $form.find("[name='fullname']").addClass("field-error");
        }

        if (!email || !emailRegex.test(email)) {
            errors.push("Enter a valid Email address.");
            $form.find("[name='email']").addClass("field-error");
        }

        if (phone && !/^\d{10}$/.test(phone)) {
            errors.push("Phone Number must be exactly 10 digits.");
            $form.find("[name='phoneno']").addClass("field-error");
        }

        if (!username || username.length < 5) {
            errors.push("Username must be at least 5 characters.");
            $form.find("[name='username']").addClass("field-error");
        }

        if (!password || password.length < 8) {
            errors.push("Password must be at least 8 characters.");
            $form.find("[name='password']").addClass("field-error");
        }

        if (!confirmPassword) {
            errors.push("Confirm Password is required.");
            $form.find("[name='confirm_password']").addClass("field-error");
        } else if (password !== confirmPassword) {
            errors.push("Password and Confirm Password must match.");
            $form.find("[name='confirm_password']").addClass("field-error");
        }

        if (!gender) {
            errors.push("Please select Gender.");
        }

        if (errors.length) {
            e.preventDefault();
            showErrors(errors);
        }
    });
});

$(function () {
    $("#registrationForm").on("reset", function () {
        $(this).find(".validation-summary").hide().empty();
        $(this).find(".is-invalid").removeClass("is-invalid");
        $(this).find("small.validation-error").remove();
    });
});

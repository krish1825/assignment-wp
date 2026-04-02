(function ($) {
    "use strict";

    if (!$ || !$.validator) {
        return;
    }

    if (!document.getElementById("ticketvarse-validation-styles")) {
        var style = document.createElement("style");
        style.id = "ticketvarse-validation-styles";
        style.textContent = [
            ".validation-summary{display:none;margin-bottom:16px;padding:12px 14px;border-radius:10px;border:1px solid #fca5a5;background:#fef2f2;color:#b91c1c;font-weight:600;}",
            "small.validation-error{display:block;margin-top:6px;color:#dc2626;font-size:0.85rem;font-weight:600;}",
            ".is-invalid,.has-error{border-color:#dc2626 !important;box-shadow:none;}",
            ".radio-group-error{display:block;margin-top:6px;color:#dc2626;font-size:0.85rem;font-weight:600;}"
        ].join("");
        document.head.appendChild(style);
    }

    function ensureSummary($form) {
        var $summary = $form.find(".validation-summary").first();
        if (!$summary.length) {
            $summary = $('<div class="validation-summary"></div>');
            $form.prepend($summary);
        }
        return $summary;
    }

    function methodIs(method) {
        return function () {
            return $("#paymentMethodInput").val() === method;
        };
    }

    function normalizedToday() {
        var today = new Date();
        today.setHours(0, 0, 0, 0);
        return today;
    }

    $.validator.addMethod("regex", function (value, element, pattern) {
        if (this.optional(element)) {
            return true;
        }

        return pattern.test(value);
    }, "Please enter a valid value.");

    $.validator.addMethod("phoneDigits", function (value, element) {
        if (this.optional(element)) {
            return true;
        }

        return /^\d{10,15}$/.test(String(value).replace(/\D/g, ""));
    }, "Please enter a valid phone number.");

    $.validator.addMethod("notFutureDate", function (value, element) {
        if (this.optional(element)) {
            return true;
        }

        var selected = new Date(value);
        selected.setHours(0, 0, 0, 0);
        return selected <= normalizedToday();
    }, "Please choose a valid date.");

    $.validator.addMethod("notPastDate", function (value, element) {
        if (this.optional(element)) {
            return true;
        }

        var selected = new Date(value);
        selected.setHours(0, 0, 0, 0);
        return selected >= normalizedToday();
    }, "Please choose today or a future date.");

    $.validator.addMethod("validImageFile", function (value, element) {
        if (this.optional(element)) {
            return true;
        }

        var file = element.files && element.files[0];
        if (!file) {
            return false;
        }

        return /^image\//.test(file.type) || /\.(jpg|jpeg|png|gif|webp)$/i.test(file.name);
    }, "Please upload a valid image file.");

    $.validator.addMethod("greaterThanZero", function (value, element) {
        if (this.optional(element)) {
            return true;
        }

        return Number(value) > 0;
    }, "Please enter a value greater than zero.");

    $.validator.addMethod("schedulePayloadRequired", function (value) {
        try {
            var parsed = JSON.parse(value || "[]");
            return Array.isArray(parsed) && parsed.length > 0;
        } catch (error) {
            return false;
        }
    }, "Add at least one show schedule.");

    $.validator.addMethod("trimmedRequired", function (value, element) {
        return this.optional(element) || $.trim(value).length > 0;
    }, "This field is required.");

    function buildOptions(options) {
        return $.extend(true, {
            ignore: ":hidden:not([name='payment_method']):not([name='venue']):not([name='time']):not([name='seats']):not([name='subtotal']):not([name='total']):not([name='movie_schedule_payload'])",
            errorElement: "small",
            errorClass: "validation-error",
            highlight: function (element) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element) {
                $(element).removeClass("is-invalid");
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio")) {
                    var $group = element.closest(".inline");
                    if ($group.length) {
                        error.addClass("radio-group-error").insertAfter($group);
                    } else {
                        error.insertAfter(element.closest("label"));
                    }
                    return;
                }

                if (element.attr("type") === "checkbox" && element.closest(".inline").length) {
                    error.addClass("radio-group-error").insertAfter(element.closest(".inline"));
                    return;
                }

                var $formGroup = element.closest(".form-group");
                var $placeholder = $formGroup.find(".error-message").first();

                if ($placeholder.length) {
                    $placeholder.replaceWith(error);
                    return;
                }

                error.insertAfter(element);
            },
            invalidHandler: function (event, validator) {
                var $summary = ensureSummary($(event.target));
                if (!validator.errorList.length) {
                    $summary.hide().empty();
                    return;
                }

                $summary.html(validator.errorList.map(function (item) {
                    return item.message;
                }).join("<br>")).show();
            },
            submitHandler: function (form) {
                ensureSummary($(form)).hide().empty();
                form.submit();
            }
        }, options);
    }

    function bindValidation(selector, options) {
        $(selector).each(function () {
            $(this).validate(buildOptions(options));
        });
    }

    bindValidation("#registrationForm", {
        rules: {
            fullname: {
                required: true,
                trimmedRequired: true
            },
            email: {
                required: true,
                email: true
            },
            phoneno: {
                phoneDigits: true
            },
            dob: {
                required: true,
                notFutureDate: true
            },
            gender: {
                required: true
            },
            username: {
                required: true,
                minlength: 5
            },
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                equalTo: "[name='password']"
            },
            country: {
                required: true
            }
        },
        messages: {
            fullname: "Full Name is required.",
            email: "Enter a valid Email address.",
            phoneno: "Phone Number must be 10 to 15 digits.",
            dob: "Please select a valid Date of Birth.",
            gender: "Please select Gender.",
            username: "Username must be at least 5 characters.",
            password: "Password must be at least 8 characters.",
            confirm_password: {
                required: "Confirm Password is required.",
                equalTo: "Password and Confirm Password must match."
            },
            country: "Please select Country."
        }
    });

    bindValidation("#loginForm", {
        rules: {
            user_id: {
                required: true,
                trimmedRequired: true
            },
            password: {
                required: true
            }
        },
        messages: {
            user_id: "User ID is required.",
            password: "Password is required."
        }
    });

    bindValidation("form[action*='resend_verification.php']", {
        rules: {
            user_id: {
                required: true,
                trimmedRequired: true
            }
        },
        messages: {
            user_id: "Enter your User ID before requesting verification email."
        }
    });

    bindValidation("form[action='forgot_password.php']", {
        rules: {
            identifier: {
                required: true,
                trimmedRequired: true
            }
        },
        messages: {
            identifier: "Enter your user ID or email address."
        }
    });

    bindValidation("form[action='reset_password.php']", {
        rules: {
            password: {
                required: true,
                minlength: 8
            },
            confirm_password: {
                required: true,
                equalTo: "[name='password']"
            }
        },
        messages: {
            password: "Password must be at least 8 characters.",
            confirm_password: {
                required: "Please confirm your new password.",
                equalTo: "Passwords do not match."
            }
        }
    });

    bindValidation("#paymentForm", {
        rules: {
            card_number: {
                required: methodIs("card"),
                regex: /^\d{4}\s?\d{4}\s?\d{4}\s?\d{4}$/
            },
            card_name: {
                required: methodIs("card"),
                trimmedRequired: true
            },
            card_expiry: {
                required: methodIs("card"),
                regex: /^(0[1-9]|1[0-2])\/\d{2}$/
            },
            card_cvv: {
                required: methodIs("card"),
                regex: /^\d{3}$/
            },
            upi_id: {
                required: methodIs("upi"),
                regex: /^[\w.\-]{2,}@[a-zA-Z]{2,}$/
            },
            bank_name: {
                required: methodIs("netbanking")
            },
            wallet_name: {
                required: methodIs("wallet")
            },
            seats: {
                required: true
            },
            total: {
                required: true,
                greaterThanZero: true
            }
        },
        messages: {
            card_number: "Enter a valid 16-digit card number.",
            card_name: "Cardholder name is required.",
            card_expiry: "Enter expiry in MM/YY format.",
            card_cvv: "Enter a valid 3-digit CVV.",
            upi_id: "Enter a valid UPI ID.",
            bank_name: "Select a bank to continue.",
            wallet_name: "Select a wallet to continue.",
            seats: "Your booking summary is incomplete. Please select seats again.",
            total: "Your booking summary is incomplete. Please select seats again."
        }
    });

    bindValidation("#normalProfileForm", {
        rules: {
            full_name: {
                required: true,
                minlength: 3
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                phoneDigits: true
            },
            dob: {
                notFutureDate: true
            },
            bio: {
                maxlength: 250
            }
        },
        messages: {
            full_name: "Full Name must be at least 3 characters.",
            email: "Enter a valid email address.",
            phone: "Phone number must be 10 to 15 digits.",
            dob: "Date of Birth cannot be in the future.",
            bio: "Bio must be 250 characters or fewer."
        }
    });

    bindValidation("#paymentMethodForm", {
        rules: {
            method_type: {
                required: true
            },
            label: {
                required: true,
                minlength: 3
            }
        },
        messages: {
            method_type: "Enter a payment method type.",
            label: "Label must be at least 3 characters."
        }
    });

    bindValidation("#slotForm", {
        rules: {
            date: {
                required: true,
                notPastDate: true
            },
            venue: {
                required: true
            },
            time: {
                required: true
            }
        },
        messages: {
            date: "Please choose today or a future date.",
            venue: "Please select a venue.",
            time: "Please select a show time."
        }
    });

    bindValidation("#seatBookingForm", {
        rules: {
            seats: {
                required: true
            },
            subtotal: {
                required: true,
                greaterThanZero: true
            },
            total: {
                required: true,
                greaterThanZero: true
            }
        },
        messages: {
            seats: "Please select your seats before continuing.",
            subtotal: "Please select your seats before continuing.",
            total: "Please select your seats before continuing."
        }
    });

    bindValidation("#profileForm", {
        rules: {
            admin_name: {
                required: true,
                minlength: 3,
                regex: /^[a-zA-Z\s.]+$/
            },
            admin_email: {
                required: true,
                email: true
            },
            admin_phone: {
                required: true,
                phoneDigits: true
            },
            admin_bio: {
                maxlength: 250
            }
        },
        messages: {
            admin_name: "Name must be at least 3 characters and use letters only.",
            admin_email: "Enter a valid email address.",
            admin_phone: "Phone number must be 10 to 15 digits.",
            admin_bio: "Bio must be 250 characters or fewer."
        }
    });

    bindValidation("#venueForm", {
        rules: {
            venue_city: {
                required: true,
                minlength: 2
            },
            venue_name: {
                required: true,
                minlength: 3
            },
            venue_area: {
                minlength: 3
            }
        },
        messages: {
            venue_city: "City is required.",
            venue_name: "Venue Name must be at least 3 characters.",
            venue_area: "Area must be at least 3 characters."
        }
    });

    bindValidation("#adminSignupForm", {
        rules: {
            admin_name: {
                required: true,
                minlength: 3
            },
            admin_email: {
                required: true,
                email: true
            },
            admin_phone: {
                required: true,
                phoneDigits: true
            },
            admin_password: {
                required: true,
                minlength: 8
            },
            admin_password_confirm: {
                required: true,
                equalTo: "[name='admin_password']"
            }
        },
        messages: {
            admin_name: "Full Name must be at least 3 characters.",
            admin_email: "Enter a valid email address.",
            admin_phone: "Phone number must be 10 to 15 digits.",
            admin_password: "Password must be at least 8 characters.",
            admin_password_confirm: {
                required: "Please confirm your password.",
                equalTo: "Passwords do not match."
            }
        }
    });

    bindValidation("#eventForm", {
        rules: {
            event_name: {
                required: true,
                minlength: 3
            },
            event_category: {
                required: true
            },
            event_date: {
                required: true,
                notPastDate: true
            },
            event_time: {
                required: true
            },
            event_location: {
                required: true,
                minlength: 3
            },
            event_description: {
                required: true,
                minlength: 10,
                maxlength: 500
            },
            event_photo: {
                required: true,
                validImageFile: true
            },
            event_price: {
                required: true,
                min: 0
            },
            event_seats: {
                required: true,
                min: 1
            }
        },
        messages: {
            event_name: "Event name must be at least 3 characters.",
            event_category: "Please select a category.",
            event_date: "Please select today or a future date.",
            event_time: "Please select an event time.",
            event_location: "Location must be at least 3 characters.",
            event_description: {
                required: "Description is required.",
                minlength: "Description must be at least 10 characters.",
                maxlength: "Description must be less than 500 characters."
            },
            event_photo: "Photo is required.",
            event_price: "Price must be 0 or greater.",
            event_seats: "Seats must be at least 1."
        }
    });

    bindValidation("#movieForm", {
        rules: {
            movie_title: {
                required: true,
                minlength: 2
            },
            movie_genre: {
                required: true
            },
            movie_date: {
                required: true
            },
            movie_duration: {
                required: true,
                min: 1
            },
            movie_language: {
                required: true,
                minlength: 2
            },
            movie_description: {
                required: true,
                minlength: 10,
                maxlength: 500
            },
            movie_photo: {
                required: true,
                validImageFile: true
            },
            movie_price: {
                required: true,
                min: 0
            },
            movie_shows: {
                required: true,
                min: 1
            },
            movie_schedule_payload: {
                schedulePayloadRequired: true
            }
        },
        messages: {
            movie_title: "Movie title must be at least 2 characters.",
            movie_genre: "Please select a genre.",
            movie_date: "Please select a release date.",
            movie_duration: "Duration must be at least 1 minute.",
            movie_language: "Language is required.",
            movie_description: {
                required: "Description is required.",
                minlength: "Description must be at least 10 characters.",
                maxlength: "Description must be less than 500 characters."
            },
            movie_photo: "Photo is required.",
            movie_price: "Price must be 0 or greater.",
            movie_shows: "Shows per day must be at least 1."
        }
    });

    bindValidation(".movie-schedule-form", {
        rules: {
            schedule_city: {
                required: true
            },
            schedule_venue: {
                required: true
            },
            schedule_screen: {
                required: true
            },
            schedule_time: {
                required: true
            }
        },
        messages: {
            schedule_city: "Please select a city.",
            schedule_venue: "Please select a venue.",
            schedule_screen: "Please select a screen.",
            schedule_time: "Please select a show time."
        }
    });

    bindValidation(".search-form", {
        rules: {
            search: {
                required: true,
                trimmedRequired: true
            }
        },
        messages: {
            search: "Enter something to search."
        },
        submitHandler: function (form, event) {
            ensureSummary($(form)).hide().empty();
            if (typeof window.handleSiteSearch === "function" && event) {
                return window.handleSiteSearch(event);
            }
            form.submit();
        }
    });
}(window.jQuery));

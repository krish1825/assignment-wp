<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up | Ticketvarse</title>
<link rel="stylesheet" href="style.css">

<style>
*{
    box-sizing: border-box;
    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
}

body{
    margin: 0;
    background: linear-gradient(165deg, #f7f9ff, #dfe9ff);
    background-attachment: fixed;
    min-height: 100vh;
    padding-top: 78px;
    color: #0f172a;
}

.btn{
    background:#facc15;
    border:none;
    padding:8px 15px;
    cursor:pointer;
    border-radius:6px;
    font-weight:bold;
}

/* Main container */
main{
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 15px;
}

/* Form card */
.form-container{
    background:white;
    width:100%;
    max-width:700px;
    padding:30px;
    border-radius:12px;
    border: 1px solid #d6e0f5;
    box-shadow:0 20px 35px rgba(15, 23, 42, 0.12);
}

h2{
    text-align:center;
    margin-bottom:25px;
    color:#0f172a;
}

fieldset{
    border:1px solid #d6e0f5;
    border-radius:8px;
    padding:20px;
    margin-bottom:20px;
}

legend{
    padding:0 10px;
    font-weight:bold;
    color:#0284c7;
}

label{
    font-weight:500;
    margin-bottom:5px;
    display:block;
}

input, select, textarea{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border-radius:6px;
    border:1px solid #bfd8ff;
    font-size:14px;
}

input:focus, textarea:focus, select:focus{
    outline:none;
    border-color:#0ea5e9;
    box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.16);
}

.inline{
    display:flex;
    gap:15px;
    margin-bottom:15px;
}

.inline label{
    font-weight:normal;
}

.actions{
    display:flex;
    justify-content:space-between;
    gap:10px;
}

.actions button{
    flex:1;
    padding:12px;
    font-size:16px;
    border:none;
    border-radius:6px;
    cursor:pointer;
}

.submit-btn{
    background:linear-gradient(135deg, #0ea5e9, #0284c7);
    color:white;
}

.reset-btn{
    background:#e2e8f0;
}

.submit-btn:hover{
    filter: brightness(0.95);
}

.reset-btn:hover{
    background:#cbd5e1;
}

.error-box{
    display:none;
    background:#fee2e2;
    color:#991b1b;
    border:1px solid #fecaca;
    padding:10px 12px;
    border-radius:6px;
    margin-bottom:14px;
}

.field-error{
    border-color:#dc2626 !important;
}
</style>
</head>

<body>

<header class="navbar">
<div class="logo">Ticketvarse</div>
<nav>
<a href="home.php">Home</a>
<a href="movies.php">Movies</a>
<a href="events.php">Events</a>
<a href="Offers.php">Offers</a>
<a href="My_Bookings.php">My Bookings</a>
<a href="Sign_in.php">Sign In</a>
</nav>
</header>

<main>
<div class="form-container">
<h2>User Registration Form</h2>

<form id="registrationForm" action="regprocess.php" method="post" enctype="multipart/form-data" novalidate>
<div id="formErrors" class="error-box"></div>

<fieldset>
<legend>Personal Information</legend>

<label>Full Name</label>
<input type="text" name="fullname">

<label>Email</label>
<input type="email" name="email">

<label>Phone Number</label>
<input type="tel" name="phoneno" placeholder="10 digit number">

<label>Date of Birth</label>
<input type="date" name="dob">

<label>Gender</label>
<div class="inline">
<label><input type="radio" name="gender" value="Male"> Male</label>
<label><input type="radio" name="gender" value="Female"> Female</label>
<label><input type="radio" name="gender" value="Other"> Other</label>
</div>
</fieldset>

<fieldset>
<legend>Account Details</legend>

<label>Username</label>
<input type="text" name="username">

<label>Password</label>
<input type="password" name="password">

<label>Confirm Password</label>
<input type="password" name="confirm_password">
</fieldset>

<fieldset>
<legend>Additional Information</legend>

<label>Country</label>
<select name="country">
<option value="">-- Select Country --</option>
<option value="India">India</option>
<option value="Germany">Germany</option>
<option value="USA">USA</option>
</select>

<label>Interests</label>
<div class="inline">
<label><input type="checkbox" name="interests[]" value="Horror"> Horror</label>
<label><input type="checkbox" name="interests[]" value="Funny"> Funny</label>
<label><input type="checkbox" name="interests[]" value="Drama"> Drama</label>
<label><input type="checkbox" name="interests[]" value="Action"> Action</label>
</div>

<label>Bio</label>
<textarea name="bio" rows="4" placeholder="Tell us about yourself"></textarea>

<label>Photo</label>
<input type="file" name="photo">
</fieldset>

<div class="actions">
<button type="submit" class="submit-btn">Register</button>
<button type="reset" class="reset-btn">Clear</button>
</div>

</form>
</div>
</main>

<footer class="site-footer">
<div class="footer-grid">
<div class="footer-col">
<h4>Ticketvarse</h4>
<p>Book movie and event tickets with easy checkout and best prices.</p>
</div>
<div class="footer-col">
<h4>Quick Links</h4>
<a href="home.php">Home</a>
<a href="movies.php">Movies</a>
<a href="events.php">Events</a>
<a href="Offers.php">Offers</a>
</div>
<div class="footer-col">
<h4>Support</h4>
<a href="My_Bookings.php">My Bookings</a>
<a href="Sign_in.php">Sign In</a>
<a href="sign_up.php">Sign Up</a>
</div>
<div class="footer-col">
<h4>Contact</h4>
<p>Email: support@ticketvarse.com</p>
<p>Phone: +91 90000 00000</p>
</div>
</div>
<div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
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
</script>

</body>
</html>


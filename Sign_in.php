<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="signin.css">
    <style>
        .error-box {
            display: none;
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 10px 12px;
            border-radius: 6px;
            margin-bottom: 12px;
            text-align: left;
        }

        .field-error {
            border-color: #dc2626 !important;
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
        <a href="sign_up.php">Sign Up</a>
    </nav>
</header>

<main class="auth-main">
    <div class="login-container">
        <div class="login-box">
            <h2>Sign In</h2>
            <p>Welcome back! Please login to your account</p>

            <form id="loginForm" action="index.php" method="post" novalidate>
                <div id="loginErrors" class="error-box"></div>

                <input type="email" name="email" placeholder="Email Address">
                <input type="password" name="password" placeholder="Password">

                <div class="options">
                    <label>
                        <input type="checkbox" name="remember_me"> Remember me
                    </label>
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit">Sign In</button>
            </form>

            <div class="divider">OR</div>

            <div class="social-login">
                <button class="google" onclick="googleLogin()">Sign in with Google</button>
                <button class="facebook" onclick="facebookLogin()">Sign in with Facebook</button>
            </div>

            <p class="signup-link">
                Don't have an account? <a href="sign_up.php">Sign Up</a>
            </p>
        </div>
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
</script>

</body>
</html>


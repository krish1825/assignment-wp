<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign In | Ticketvarse</title>
    <link rel="stylesheet" href="signin.css">
</head>
<body>

<div class="login-container">
    <div class="login-box">
        <h2>Sign In</h2>
        <p>Welcome back! Please login to your account</p>

        <form action="index.php" method="post">
            <input type="email" placeholder="Email Address" required>
            <input type="password" placeholder="Password" required>

            <div class="options">
                <label>
                    <input type="checkbox"> Remember me
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
        <script>
            function googleLogin() {
            window.location.href = "https://accounts.google.com/AccountChooser";
            }
            function facebookLogin() {
            window.open("https://www.facebook.com/login", "_blank");
        }
        </script>


        <p class="signup-link">
            Don’t have an account? <a href="sign_up.php">Sign Up</a>
        </p>
    </div>
</div>

</body>
</html>

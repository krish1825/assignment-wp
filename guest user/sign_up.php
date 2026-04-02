<?php
$error = $_GET['error'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up | Ticketvarse</title>
<link rel="stylesheet" href="style.css">
<link rel="stylesheet" href="sign-up.css">
</head>

<body>

<header class="navbar">
<div class="logo">Ticketvarse</div>
<nav>
<a href="home.php">Home</a>
<a href="movies.php">Movies</a>
<a href="events.php">Events</a>
<a href="Offers.php">Offers</a>
<a href="sign_in.php">My Bookings</a>
<a href="Sign_in.php">Sign In</a>
</nav>
</header>

<main>
<div class="form-container">
<h2>User Registration Form</h2>

<form id="registrationForm" action="regprocess.php" method="post" enctype="multipart/form-data" novalidate>
<input type="hidden" name="source" value="guest">
<div id="formErrors" class="error-box"<?php if ($error === ''): ?> style="display:none;"<?php endif; ?>><?= htmlspecialchars($error) ?></div>

<fieldset>
<legend>Personal Information</legend>
<label>Full Name</label>
<input type="text" name="fullname" value="<?= htmlspecialchars($_GET['fullname'] ?? '') ?>">
<label>Email</label>
<input type="email" name="email" value="<?= htmlspecialchars($_GET['email'] ?? '') ?>">
<label>Phone Number</label>
<input type="tel" name="phoneno" placeholder="10 digit number" value="<?= htmlspecialchars($_GET['phoneno'] ?? '') ?>">
<label>Date of Birth</label>
<input type="date" name="dob" value="<?= htmlspecialchars($_GET['dob'] ?? '') ?>">
<label>Gender</label>
<div class="inline">
<label><input type="radio" name="gender" value="Male" <?= ($_GET['gender'] ?? '') === 'Male' ? 'checked' : '' ?>> Male</label>
<label><input type="radio" name="gender" value="Female" <?= ($_GET['gender'] ?? '') === 'Female' ? 'checked' : '' ?>> Female</label>
<label><input type="radio" name="gender" value="Other" <?= ($_GET['gender'] ?? '') === 'Other' ? 'checked' : '' ?>> Other</label>
</div>
</fieldset>

<fieldset>
<legend>Account Details</legend>
<label>Username</label>
<input type="text" name="username" value="<?= htmlspecialchars($_GET['username'] ?? '') ?>">
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
<option value="India" <?= ($_GET['country'] ?? '') === 'India' ? 'selected' : '' ?>>India</option>
<option value="Germany" <?= ($_GET['country'] ?? '') === 'Germany' ? 'selected' : '' ?>>Germany</option>
<option value="USA" <?= ($_GET['country'] ?? '') === 'USA' ? 'selected' : '' ?>>USA</option>
</select>
<label>Interests</label>
<div class="inline">
<label><input type="checkbox" name="interests[]" value="Horror"> Horror</label>
<label><input type="checkbox" name="interests[]" value="Funny"> Funny</label>
<label><input type="checkbox" name="interests[]" value="Drama"> Drama</label>
<label><input type="checkbox" name="interests[]" value="Action"> Action</label>
</div>
<label>Bio</label>
<textarea name="bio" rows="4" placeholder="Tell us about yourself"><?= htmlspecialchars($_GET['bio'] ?? '') ?></textarea>
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
<div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div>
<div class="footer-col"><h4>Quick Links</h4><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a></div>
<div class="footer-col"><h4>Support</h4><a href="My_Bookings.php">My Bookings</a><a href="Sign_in.php">Sign In</a><a href="sign_up.php">Sign Up</a></div>
<div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div>
</div>
<div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
<script src="../assets/js/form-validation.js"></script>
<script src="sign-up.js"></script>
</body>
</html>

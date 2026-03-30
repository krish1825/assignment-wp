<?php require_once 'session_check.php'; 

$admin_id = $_SESSION['admin_id'];
$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['admin_name']);
    $email = trim($_POST['admin_email']);
    $phone = trim($_POST['admin_phone']);
    $bio = trim($_POST['admin_bio']);
    
    if (empty($name) || empty($email) || empty($phone)) {
        $error = "Name, email, and phone are required.";
    } else {
        $stmt = $conn->prepare("UPDATE admins SET full_name = ?, email = ?, phone = ?, bio = ? WHERE id = ?");
        if ($stmt->execute([$name, $email, $phone, $bio, $admin_id])) {
            $success = "Profile updated successfully!";
            $_SESSION['admin_name'] = $name;
        } else {
            $error = "Failed to update profile.";
        }
    }
}

$stmt = $conn->prepare("SELECT * FROM admins WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Admin Profile</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="sidebar" id="sidebar">
        <div class="logo">TicketVerse</div>
        <a href="index1.php">Dashboard</a>
        <a href="events.php">Manage Events</a>
        <a href="bookings.php">Bookings</a>
        <a href="users.php">Users</a>
        <a href="profile.php" class="active">Profile</a>
        <a href="Sign_in.php?logout=true">Logout</a>
    </div>

    <div class="main">
        <div class="topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
            <h3>Admin Profile</h3>
            <a class="profile-btn" href="profile.php">Admin Profile</a>
        </div>

        <div class="page-content">
            <div class="profile-layout">
                <div class="profile-card">
                    <div class="profile-avatar"><?php echo strtoupper(substr($admin['full_name'], 0, 1)); ?></div>
                    <h2><?php echo htmlspecialchars($admin['full_name']); ?></h2>
                    <p>Super Admin</p>
                    <span class="profile-badge">Active</span>
                </div>

                <form class="form-card profile-form" id="profileForm" action="profile.php" method="post" novalidate>
                    <h2 class="section-title">Profile Details</h2>
                    
                    <?php if ($error): ?>
                        <div style="background: #ffebee; color: #c62828; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($success): ?>
                        <div style="background: #e8f5e9; color: #2e7d32; padding: 10px; border-radius: 8px; margin-bottom: 20px;">
                            <?php echo htmlspecialchars($success); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-grid">
                        <div class="form-group">
                            <label for="admin_name">Full Name</label>
                            <input type="text" id="admin_name" name="admin_name" value="<?php echo htmlspecialchars($admin['full_name']); ?>">
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Email</label>
                            <input type="email" id="admin_email" name="admin_email" value="<?php echo htmlspecialchars($admin['email']); ?>">
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="admin_phone">Phone</label>
                            <input type="tel" id="admin_phone" name="admin_phone" value="<?php echo htmlspecialchars($admin['phone']); ?>">
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group">
                            <label for="admin_role">Role</label>
                            <input type="text" id="admin_role" name="admin_role" value="Super Admin" readonly>
                        </div>
                        <div class="form-group full-width">
                            <label for="admin_bio">Bio</label>
                            <textarea id="admin_bio" name="admin_bio" placeholder="Write a short profile bio"><?php echo htmlspecialchars($admin['bio'] ?? ''); ?></textarea>
                            <small class="error-message"></small>
                        </div>
                        <div class="form-group full-width">
                            <button type="submit" class="submit-btn">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="script.js"></script>
    <script>
        $(function () {
            var $form = $("#profileForm");

            function setError($field, message) {
                $field.addClass("has-error");
                $field.closest(".form-group").find(".error-message").text(message);
            }

            function clearError($field) {
                $field.removeClass("has-error");
                $field.closest(".form-group").find(".error-message").text("");
            }

            function validateName() {
                var $field = $("#admin_name");
                var value = $.trim($field.val());

                if (value.length < 3) {
                    setError($field, "Name must be at least 3 characters.");
                    return false;
                }

                if (!/^[a-zA-Z\s.]+$/.test(value)) {
                    setError($field, "Name can contain letters, spaces, and dots only.");
                    return false;
                }

                clearError($field);
                return true;
            }

            function validateEmail() {
                var $field = $("#admin_email");
                var value = $.trim($field.val());
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;

                if (!emailPattern.test(value)) {
                    setError($field, "Enter a valid email address.");
                    return false;
                }

                clearError($field);
                return true;
            }

            function validatePhone() {
                var $field = $("#admin_phone");
                var value = $.trim($field.val());

                if (value === "") {
                    setError($field, "Phone number is required.");
                    return false;
                }

                var digitsOnly = value.replace(/\D/g, "");
                if (digitsOnly.length < 10 || digitsOnly.length > 15) {
                    setError($field, "Phone number must be 10 to 15 digits.");
                    return false;
                }

                clearError($field);
                return true;
            }

            function validateBio() {
                var $field = $("#admin_bio");
                var value = $.trim($field.val());

                if (value.length < 10) {
                    setError($field, "Bio must be at least 10 characters.");
                    return false;
                }

                if (value.length > 250) {
                    setError($field, "Bio must be less than 250 characters.");
                    return false;
                }

                clearError($field);
                return true;
            }

            $("#admin_name").on("input blur", validateName);
            $("#admin_email").on("input blur", validateEmail);
            $("#admin_phone").on("input blur", validatePhone);
            $("#admin_bio").on("input blur", validateBio);

            $form.on("submit", function (event) {
                var isNameValid = validateName();
                var isEmailValid = validateEmail();
                var isPhoneValid = validatePhone();
                var isBioValid = validateBio();

                if (!isNameValid || !isEmailValid || !isPhoneValid || !isBioValid) {
                    event.preventDefault();
                }
            });
        });
    </script>

</body>

</html>

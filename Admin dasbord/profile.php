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
        <a href="index.php">Dashboard</a>
        <a href="events.php">Manage Events</a>
        <a href="bookings.php">Bookings</a>
        <a href="users.php">Users</a>
        <a href="profile.php">Profile</a>
        <a href="sign_in.php">Logout</a>
    </div>

    <div class="main">
        <div class="topbar">
            <h3>Admin Profile</h3>
            <a class="profile-btn" href="profile.php">Admin Profile</a>
        </div>

        <div class="page-content">
            <div class="profile-layout">
                <div class="profile-card">
                    <div class="profile-avatar">A</div>
                    <h2>Admin</h2>
                    <p>Krish Limbasiya</p>
                    <span class="profile-badge">Active</span>
                </div>

                <form class="form-card profile-form" action="#" method="post">
                    <h2 class="section-title">Profile Details</h2>
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="admin_name">Full Name</label>
                            <input type="text" id="admin_name" name="admin_name" value="Krish Limbasiy  " required>
                        </div>
                        <div class="form-group">
                            <label for="admin_email">Email</label>
                            <input type="email" id="admin_email" name="admin_email" value="krish@ticketverse.com" required>
                        </div>
                        <div class="form-group">
                            <label for="admin_phone">Phone</label>
                            <input type="tel" id="admin_phone" name="admin_phone" value="+91 555 123 4567">
                        </div>
                        <div class="form-group">
                            <label for="admin_role">Role</label>
                            <input type="text" id="admin_role" name="admin_role" value="Super Admin" readonly>
                        </div>
                        <div class="form-group full-width">
                            <label for="admin_bio">Bio</label>
                            <textarea id="admin_bio" name="admin_bio" placeholder="Write a short profile bio">Manages events, movies, users, and bookings for TicketVerse.</textarea>
                        </div>
                        <div class="form-group full-width">
                            <button type="submit" class="submit-btn">Update Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="script.js"></script>
</body>

</html>
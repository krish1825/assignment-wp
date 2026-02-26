<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="profile.css">
</head>
<body>
<header class="navbar">
    <div class="logo">Ticketvarse</div>
    <nav>
        <a href="home.php">Home</a>
        <a href="movies.php">Movies</a>
        <a href="events.php">Events</a>
        <a href="Offers.php">Offers</a>
        <a href="profile.php">Profile</a>
        <a href="My_Bookings.php">My Bookings</a>
    </nav>
</header>
<div class="profile-shell">
    <section class="profile-hero">
        <div class="profile-card">
            <div class="avatar">A</div>
            <div class="profile-meta">
                <p class="eyebrow">Normal User</p>
                <h1>Alok Limbasiya</h1>
                <p class="subtitle">Member since 2023 - Ahmedabad</p>
                <div class="profile-actions">
                    <button class="btn" type="button">Edit Profile</button>
                    <button class="ghost-btn" type="button">Manage Payments</button>
                </div>
            </div>
        </div>
        <div class="profile-stats">
            <div class="stat-card">
                <h3>12</h3>
                <p>Bookings</p>
            </div>
            <div class="stat-card">
                <h3>4</h3>
                <p>Saved Offers</p>
            </div>
            <div class="stat-card">
                <h3>2</h3>
                <p>Upcoming Shows</p>
            </div>
        </div>
    </section>
    <section class="profile-grid">
        <div class="info-card">
            <h2>Personal Details</h2>
            <form class="profile-form">
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name">Full Name</label>
                        <input id="full_name" type="text" value="Alok Limbasiya">
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" value="alok@ticketvarse.com">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input id="phone" type="tel" value="+91 98765 43210">
                    </div>
                    <div class="form-group">
                        <label for="city">City</label>
                        <input id="city" type="text" value="Rajkot">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group full">
                        <label for="bio">Bio</label>
                        <textarea id="bio" rows="3">Movie buff, weekend explorer, and early bird when it comes to ticket drops.</textarea>
                    </div>
                </div>
                <div class="form-row">
                    <button class="btn" type="button">Save Changes</button>
                </div>
            </form>
        </div>
        <div class="info-card">
            <h2>Preferences</h2>
            <div class="pill-group">
                <span>Hindi Movies</span>
                <span>Live Concerts</span>
                <span>Weekend Matinee</span>
                <span>Comedy Shows</span>
            </div>
            <div class="divider"></div>
            <h3>Notifications</h3>
            <ul class="list">
                <li>SMS alerts enabled</li>
                <li>Email offers enabled</li>
                <li>Push reminders 2 hours before show</li>
            </ul>
        </div>
        <div class="info-card">
            <h2>Upcoming Bookings</h2>
            <div class="booking-item">
                <div>
                    <h4>Kung Fu Panda</h4>
                    <p>Mar 16, 2026 - 7:30 PM - Ahmedabad</p>
                </div>
                <span class="booking-chip">Confirmed</span>
            </div>
            <div class="booking-item">
                <div>
                    <h4>Arijit Singh Live</h4>
                    <p>Mar 20, 2026 - 8:00 PM - Mumbai</p>
                </div>
                <span class="booking-chip">Pending</span>
            </div>
            <div class="booking-item">
                <div>
                    <h4>Zakir Khan Stand-up</h4>
                    <p>Mar 23, 2026 - 9:00 PM - Pune</p>
                </div>
                <span class="booking-chip">Confirmed</span>
            </div>
        </div>
        <div class="info-card">
            <h2>Security</h2>
            <div class="security-row">
                <div>
                    <h4>Password</h4>
                    <p>Last updated 12 days ago</p>
                </div>
                <button class="ghost-btn" type="button">Change Password</button>
            </div>
            <div class="security-row">
                <div>
                    <h4>Two-Factor Authentication</h4>
                    <p>Protect your account with OTP login</p>
                </div>
                <button class="ghost-btn" type="button">Enable 2FA</button>
            </div>
            <div class="divider"></div>
            <p class="muted">Need help? Contact support or visit the FAQ for account recovery.</p>
        </div>
    </section>
</div>
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
            <a href="profile.php">Profile</a>
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
</body>
</html>


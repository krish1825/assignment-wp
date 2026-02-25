<!DOCTYPE html>
<html>
<head>
    <title>Add Movie</title>
    <link rel="stylesheet" href="style.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .movie-page-bg {
            background:
                radial-gradient(circle at 10% 10%, #e0e7ff 0, transparent 45%),
                radial-gradient(circle at 90% 90%, #ffe9d6 0, transparent 40%),
                linear-gradient(135deg, #f3f4f6, #eef2ff);
        }

        .movie-form-card {
            border: 1px solid #e5e7eb;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 16px 36px rgba(31, 41, 55, 0.08);
        }

        .movie-form-card .section-title {
            color: #4338ca;
            letter-spacing: 0.3px;
            margin-bottom: 18px;
        }

        .movie-form {
            max-width: 980px;
            border: 1px solid #e7ebf5;
            box-shadow: 0 8px 22px rgba(79, 70, 229, 0.08);
            background: linear-gradient(180deg, #ffffff, #fbfcff);
            padding: 24px;
            border-radius: 14px;
        }

        .movie-form .form-grid {
            gap: 18px;
        }

        .movie-form .form-group label {
            color: #312e81;
            font-weight: 700;
            margin-bottom: 7px;
        }

        .movie-form .form-group input,
        .movie-form .form-group select,
        .movie-form .form-group textarea {
            background: #f8faff;
            border: 1px solid #dbe2f0;
            border-radius: 10px;
            padding: 11px 12px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
        }

        .movie-form .form-group textarea {
            min-height: 130px;
            line-height: 1.45;
        }

        .movie-form .submit-btn {
            background: linear-gradient(135deg, #4338ca, #6366f1);
            box-shadow: 0 10px 22px rgba(67, 56, 202, 0.3);
            border-radius: 10px;
            padding: 12px 22px;
            letter-spacing: 0.2px;
        }

        .movie-form input:focus,
        .movie-form select:focus,
        .movie-form textarea:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.18);
            background: #fff;
        }

        @media (max-width: 768px) {
            .movie-form-card {
                border-radius: 12px;
                padding: 18px;
            }

            .movie-form {
                padding: 16px;
            }

            .movie-form-card .section-title {
                font-size: 22px;
            }
        }
    </style>
</head>
<body class="movie-page-bg">
<div class="sidebar" id="sidebar">
    <div class="logo">TicketVerse</div>
    <a href="index.php">Dashboard</a>
    <a href="events.php">Manage Events</a>
    <a href="bookings.php">Bookings</a>
    <a href="users.php">Users</a>
    <a href="sign_in.php">Logout</a>
</div>

<div class="main">
    <div class="topbar">
        <h3>Add Movie</h3>
        <button class="profile-btn">Admin</button>
    </div>

    <div class="page-content movie-form-card">
        <h2 class="section-title">Add New Movie</h2>
        <form class="form-card movie-form" action="events.php" method="post" enctype="multipart/form-data">
            <div class="form-grid">
                <div class="form-group">
                    <label for="movie_title">Movie Title</label>
                    <input type="text" id="movie_title" name="movie_title" placeholder="Avengers" required>
                </div>
                <div class="form-group">
                    <label for="movie_genre">Genre</label>
                    <select id="movie_genre" name="movie_genre" required>
                        <option value="">Select Genre</option>
                        <option value="action">Action</option>
                        <option value="drama">Drama</option>
                        <option value="comedy">Comedy</option>
                        <option value="thriller">Thriller</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="movie_date">Release Date</label>
                    <input type="date" id="movie_date" name="movie_date" required>
                </div>
                <div class="form-group">
                    <label for="movie_duration">Duration (minutes)</label>
                    <input type="number" id="movie_duration" name="movie_duration" min="1" placeholder="120" required>
                </div>
                <div class="form-group full-width">
                    <label for="movie_language">Language</label>
                    <input type="text" id="movie_language" name="movie_language" placeholder="English, Hindi" required>
                </div>
                <div class="form-group full-width">
                    <label for="movie_description">Description</label>
                    <textarea id="movie_description" name="movie_description" placeholder="Write movie details"></textarea>
                </div>
                <div class="form-group full-width">
                    <label for="movie_photo">Add Photo</label>
                    <input type="file" id="movie_photo" name="movie_photo" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="movie_price">Ticket Price</label>
                    <input type="number" id="movie_price" name="movie_price" min="0" placeholder="299" required>
                </div>
                <div class="form-group">
                    <label for="movie_shows">Shows Per Day</label>
                    <input type="number" id="movie_shows" name="movie_shows" min="1" placeholder="5" required>
                </div>
                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Movie</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>

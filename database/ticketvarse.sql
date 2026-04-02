CREATE DATABASE IF NOT EXISTS ticketvarse
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE ticketvarse;

CREATE TABLE IF NOT EXISTS movies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    genre VARCHAR(120) NOT NULL,
    release_date DATE NOT NULL,
    duration_minutes INT NOT NULL,
    language VARCHAR(120) NOT NULL,
    description TEXT NULL,
    ticket_price DECIMAL(10,2) NOT NULL DEFAULT 0,
    shows_per_day INT NOT NULL DEFAULT 1,
    image_path VARCHAR(255) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS events (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    category VARCHAR(120) NOT NULL,
    event_date DATE NOT NULL,
    event_time TIME NOT NULL,
    location VARCHAR(255) NOT NULL,
    description TEXT NULL,
    ticket_price DECIMAL(10,2) NOT NULL DEFAULT 0,
    available_seats INT NOT NULL DEFAULT 0,
    image_path VARCHAR(255) NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id VARCHAR(100) NOT NULL UNIQUE,
    full_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'normal',
    status VARCHAR(20) NOT NULL DEFAULT 'active',
    email_verified_at DATETIME NULL,
    verification_token_hash VARCHAR(64) NULL,
    verification_token_expires_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS password_resets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    token_hash VARCHAR(64) NOT NULL UNIQUE,
    expires_at DATETIME NOT NULL,
    used_at DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS movie_schedules (
    id INT AUTO_INCREMENT PRIMARY KEY,
    movie_id INT NOT NULL,
    city VARCHAR(100) NOT NULL,
    venue VARCHAR(255) NOT NULL,
    screen_type VARCHAR(120) NOT NULL,
    show_time VARCHAR(50) NOT NULL,
    display_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
);

INSERT INTO movies
    (title, genre, release_date, duration_minutes, language, description, ticket_price, shows_per_day, image_path, status)
VALUES
    ('Kung Fu Panda', 'Animation', '2026-03-10', 104, 'Hindi', 'A fun family adventure with martial arts action and comedy.', 499, 5, 'm74S9tsrUQUYB8Raou21B6zjbcr.jpg', 'active'),
    ('Lagan Laagii Re', 'Drama', '2026-03-13', 132, 'Gujarati', 'A romantic regional drama with music, family emotion, and heart.', 399, 4, 'lagan-laagii-re.jpg', 'active'),
    ('Bhabiji Ghar Par Hain!', 'Comedy', '2026-03-17', 118, 'Hindi', 'A comedy entertainer packed with chaos, charm, and familiar faces.', 450, 4, 'bhabiji-ghar-par-hain.jpg', 'active'),
    ('Pass Na Pass', 'Comedy', '2026-03-20', 110, 'Gujarati', 'A light-hearted campus story with humor, pressure, and friendship.', 350, 3, 'pass na pass.jpg', 'active');

INSERT INTO events
    (name, category, event_date, event_time, location, description, ticket_price, available_seats, image_path, status)
VALUES
    ('Arijit Singh Live', 'concert', '2026-03-16', '19:30:00', 'DY Patil Stadium, Mumbai', 'A full-scale live concert experience with Arijit Singh.', 1999, 1200, 'arijit-singh.jpg', 'active'),
    ('Zakir Khan Stand-up', 'standup', '2026-03-22', '20:00:00', 'Bal Gandharva, Pune', 'A weekend stand-up night with observational comedy and storytelling.', 899, 350, 'zakhir-khan.jpg', 'active'),
    ('Sunburn Arena', 'concert', '2026-03-29', '18:00:00', 'JLN Stadium, Delhi', 'An arena-scale electronic music experience with headline DJs.', 1499, 900, 'weekend-combo-offer.jpg', 'active'),
    ('Food & Music Fest', 'festival', '2026-04-05', '17:00:00', 'Riverfront Ground, Ahmedabad', 'Street food, indie artists, and an open-air festival vibe.', 499, 500, 'weekend-combo-offer.jpg', 'active');

INSERT INTO users
    (user_id, full_name, email, password, role, status, email_verified_at)
VALUES
    ('admin001', 'Admin User', 'admin@ticketvarse.com', 'admin@123', 'admin', 'active', NOW()),
    ('user001', 'Krish', 'krish@email.com', 'user@123', 'normal', 'active', NOW()),
    ('user002', 'Rahul', 'rahul@email.com', 'user@123', 'normal', 'active', NOW());

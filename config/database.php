<?php

declare(strict_types=1);

function ticketvarse_db(): PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $database = getenv('DB_NAME') ?: 'ticketvarse';
    $username = getenv('DB_USER') ?: 'root';
    $password = getenv('DB_PASS') ?: '';

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    try {
        $pdo = new PDO(
            sprintf('mysql:host=%s;port=%s;charset=utf8mb4', $host, $port),
            $username,
            $password,
            $options
        );

        $pdo->exec(sprintf(
            'CREATE DATABASE IF NOT EXISTS `%s` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci',
            str_replace('`', '``', $database)
        ));
        $pdo->exec(sprintf('USE `%s`', str_replace('`', '``', $database)));

        ticketvarse_ensure_schema($pdo);
    } catch (PDOException $exception) {
        die(
            'Database connection failed. Check MySQL in Laragon and DB credentials in config/database.php. Details: '
            . $exception->getMessage()
        );
    }

    return $pdo;
}

function ticketvarse_ensure_schema(PDO $pdo): void
{
    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS movies (
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
            status VARCHAR(20) NOT NULL DEFAULT "active",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS events (
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
            status VARCHAR(20) NOT NULL DEFAULT "active",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id VARCHAR(100) NOT NULL UNIQUE,
            full_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            role VARCHAR(20) NOT NULL DEFAULT "normal",
            status VARCHAR(20) NOT NULL DEFAULT "active",
            phone VARCHAR(20) NULL,
            dob DATE NULL,
            gender VARCHAR(20) NULL,
            country VARCHAR(100) NULL,
            interests TEXT NULL,
            bio TEXT NULL,
            photo_path VARCHAR(255) NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS payment_methods (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            method_type VARCHAR(30) NOT NULL,
            label VARCHAR(255) NOT NULL,
            details VARCHAR(255) NULL,
            is_default TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            booking_type VARCHAR(30) NOT NULL,
            show_name VARCHAR(255) NOT NULL,
            venue VARCHAR(255) NOT NULL,
            city VARCHAR(100) NULL,
            booking_date DATE NOT NULL,
            booking_time VARCHAR(50) NOT NULL,
            seats VARCHAR(255) NOT NULL,
            seat_count INT NOT NULL DEFAULT 0,
            subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
            fee DECIMAL(10,2) NOT NULL DEFAULT 0,
            total_amount DECIMAL(10,2) NOT NULL DEFAULT 0,
            payment_status VARCHAR(30) NOT NULL DEFAULT "paid",
            booking_status VARCHAR(30) NOT NULL DEFAULT "confirmed",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            booking_id INT NOT NULL,
            user_id INT NOT NULL,
            method_type VARCHAR(30) NOT NULL,
            payment_label VARCHAR(255) NOT NULL,
            amount DECIMAL(10,2) NOT NULL DEFAULT 0,
            payment_status VARCHAR(30) NOT NULL DEFAULT "paid",
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE,
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    $pdo->exec(
        'CREATE TABLE IF NOT EXISTS movie_schedules (
            id INT AUTO_INCREMENT PRIMARY KEY,
            movie_id INT NOT NULL,
            city VARCHAR(100) NOT NULL,
            venue VARCHAR(255) NOT NULL,
            screen_type VARCHAR(120) NOT NULL,
            show_time VARCHAR(50) NOT NULL,
            display_order INT NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (movie_id) REFERENCES movies(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4'
    );

    ticketvarse_ensure_column($pdo, 'movies', 'status', 'ALTER TABLE movies ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT "active"');
    ticketvarse_ensure_column($pdo, 'events', 'status', 'ALTER TABLE events ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT "active"');
    ticketvarse_ensure_column($pdo, 'users', 'role', 'ALTER TABLE users ADD COLUMN role VARCHAR(20) NOT NULL DEFAULT "normal"');
    ticketvarse_ensure_column($pdo, 'users', 'status', 'ALTER TABLE users ADD COLUMN status VARCHAR(20) NOT NULL DEFAULT "active"');
    ticketvarse_ensure_column($pdo, 'users', 'phone', 'ALTER TABLE users ADD COLUMN phone VARCHAR(20) NULL');
    ticketvarse_ensure_column($pdo, 'users', 'dob', 'ALTER TABLE users ADD COLUMN dob DATE NULL');
    ticketvarse_ensure_column($pdo, 'users', 'gender', 'ALTER TABLE users ADD COLUMN gender VARCHAR(20) NULL');
    ticketvarse_ensure_column($pdo, 'users', 'country', 'ALTER TABLE users ADD COLUMN country VARCHAR(100) NULL');
    ticketvarse_ensure_column($pdo, 'users', 'interests', 'ALTER TABLE users ADD COLUMN interests TEXT NULL');
    ticketvarse_ensure_column($pdo, 'users', 'bio', 'ALTER TABLE users ADD COLUMN bio TEXT NULL');
    ticketvarse_ensure_column($pdo, 'users', 'photo_path', 'ALTER TABLE users ADD COLUMN photo_path VARCHAR(255) NULL');

    $movieCount = (int) $pdo->query('SELECT COUNT(*) FROM movies')->fetchColumn();
    if ($movieCount === 0) {
        $movieStatement = $pdo->prepare(
            'INSERT INTO movies
                (title, genre, release_date, duration_minutes, language, description, ticket_price, shows_per_day, image_path, status)
             VALUES
                (:title, :genre, :release_date, :duration_minutes, :language, :description, :ticket_price, :shows_per_day, :image_path, :status)'
        );
        $movies = [
            ['title' => 'Kung Fu Panda', 'genre' => 'Animation', 'release_date' => '2026-03-10', 'duration_minutes' => 104, 'language' => 'Hindi', 'description' => 'A fun family adventure with martial arts action and comedy.', 'ticket_price' => 499, 'shows_per_day' => 5, 'image_path' => 'm74S9tsrUQUYB8Raou21B6zjbcr.jpg', 'status' => 'active'],
            ['title' => 'Lagan Laagii Re', 'genre' => 'Drama', 'release_date' => '2026-03-13', 'duration_minutes' => 132, 'language' => 'Gujarati', 'description' => 'A romantic regional drama with music, family emotion, and heart.', 'ticket_price' => 399, 'shows_per_day' => 4, 'image_path' => 'lagan-laagii-re.jpg', 'status' => 'active'],
            ['title' => 'Bhabiji Ghar Par Hain!', 'genre' => 'Comedy', 'release_date' => '2026-03-17', 'duration_minutes' => 118, 'language' => 'Hindi', 'description' => 'A comedy entertainer packed with chaos, charm, and familiar faces.', 'ticket_price' => 450, 'shows_per_day' => 4, 'image_path' => 'bhabiji-ghar-par-hain.jpg', 'status' => 'active'],
            ['title' => 'Pass Na Pass', 'genre' => 'Comedy', 'release_date' => '2026-03-20', 'duration_minutes' => 110, 'language' => 'Gujarati', 'description' => 'A light-hearted campus story with humor, pressure, and friendship.', 'ticket_price' => 350, 'shows_per_day' => 3, 'image_path' => 'pass na pass.jpg', 'status' => 'active'],
        ];
        foreach ($movies as $movie) {
            $movieStatement->execute($movie);
        }
    }

    $eventCount = (int) $pdo->query('SELECT COUNT(*) FROM events')->fetchColumn();
    if ($eventCount === 0) {
        $eventStatement = $pdo->prepare(
            'INSERT INTO events
                (name, category, event_date, event_time, location, description, ticket_price, available_seats, image_path, status)
             VALUES
                (:name, :category, :event_date, :event_time, :location, :description, :ticket_price, :available_seats, :image_path, :status)'
        );
        $events = [
            ['name' => 'Arijit Singh Live', 'category' => 'concert', 'event_date' => '2026-03-16', 'event_time' => '19:30:00', 'location' => 'DY Patil Stadium, Mumbai', 'description' => 'A full-scale live concert experience with Arijit Singh.', 'ticket_price' => 1999, 'available_seats' => 1200, 'image_path' => 'arijit-singh.jpg', 'status' => 'active'],
            ['name' => 'Zakir Khan Stand-up', 'category' => 'standup', 'event_date' => '2026-03-22', 'event_time' => '20:00:00', 'location' => 'Bal Gandharva, Pune', 'description' => 'A weekend stand-up night with observational comedy and storytelling.', 'ticket_price' => 899, 'available_seats' => 350, 'image_path' => 'zakhir-khan.jpg', 'status' => 'active'],
            ['name' => 'Sunburn Arena', 'category' => 'concert', 'event_date' => '2026-03-29', 'event_time' => '18:00:00', 'location' => 'JLN Stadium, Delhi', 'description' => 'An arena-scale electronic music experience with headline DJs.', 'ticket_price' => 1499, 'available_seats' => 900, 'image_path' => 'weekend-combo-offer.jpg', 'status' => 'active'],
            ['name' => 'Food & Music Fest', 'category' => 'festival', 'event_date' => '2026-04-05', 'event_time' => '17:00:00', 'location' => 'Riverfront Ground, Ahmedabad', 'description' => 'Street food, indie artists, and an open-air festival vibe.', 'ticket_price' => 499, 'available_seats' => 500, 'image_path' => 'weekend-combo-offer.jpg', 'status' => 'active'],
        ];
        foreach ($events as $event) {
            $eventStatement->execute($event);
        }
    }

    $userCount = (int) $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($userCount === 0) {
        $userStatement = $pdo->prepare(
            'INSERT INTO users
                (user_id, full_name, email, password, role, status, phone, country)
             VALUES
                (:user_id, :full_name, :email, :password, :role, :status, :phone, :country)'
        );
        $users = [
            ['user_id' => 'admin001', 'full_name' => 'Admin User', 'email' => 'admin@ticketvarse.com', 'password' => 'admin@123', 'role' => 'admin', 'status' => 'active', 'phone' => '9999999999', 'country' => 'India'],
            ['user_id' => 'user001', 'full_name' => 'Krish', 'email' => 'krish@email.com', 'password' => 'user@123', 'role' => 'normal', 'status' => 'active', 'phone' => '9876543210', 'country' => 'India'],
            ['user_id' => 'user002', 'full_name' => 'Rahul', 'email' => 'rahul@email.com', 'password' => 'user@123', 'role' => 'normal', 'status' => 'active', 'phone' => '9123456780', 'country' => 'India'],
        ];
        foreach ($users as $user) {
            $userStatement->execute($user);
        }
    }

    $bookingCount = (int) $pdo->query('SELECT COUNT(*) FROM bookings')->fetchColumn();
    if ($bookingCount === 0) {
        $firstUserId = (int) $pdo->query("SELECT id FROM users WHERE user_id = 'user001' LIMIT 1")->fetchColumn();
        if ($firstUserId > 0) {
            $bookingStatement = $pdo->prepare(
                'INSERT INTO bookings
                    (user_id, booking_type, show_name, venue, city, booking_date, booking_time, seats, seat_count, subtotal, fee, total_amount, payment_status, booking_status)
                 VALUES
                    (:user_id, :booking_type, :show_name, :venue, :city, :booking_date, :booking_time, :seats, :seat_count, :subtotal, :fee, :total_amount, :payment_status, :booking_status)'
            );
            $bookingStatement->execute([
                'user_id' => $firstUserId,
                'booking_type' => 'movie',
                'show_name' => 'Kung Fu Panda',
                'venue' => 'Cinepolis: Alpha One',
                'city' => 'Ahmedabad',
                'booking_date' => '2026-03-25',
                'booking_time' => '07:30 PM',
                'seats' => 'G5, G6',
                'seat_count' => 2,
                'subtotal' => 998,
                'fee' => 49,
                'total_amount' => 1047,
                'payment_status' => 'paid',
                'booking_status' => 'confirmed',
            ]);
        }
    }
}

function ticketvarse_ensure_column(PDO $pdo, string $table, string $column, string $alterSql): void
{
    $statement = $pdo->prepare(
        'SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = :table_name AND COLUMN_NAME = :column_name'
    );
    $statement->execute(['table_name' => $table, 'column_name' => $column]);
    if ((int) $statement->fetchColumn() === 0) {
        $pdo->exec($alterSql);
    }
}

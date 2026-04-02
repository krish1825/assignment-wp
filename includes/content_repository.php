<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/mail_helper.php';

function db(): PDO
{
    return ticketvarse_db();
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function default_movie_image(): string
{
    return 'm74S9tsrUQUYB8Raou21B6zjbcr.jpg';
}

function default_event_image(): string
{
    return 'arijit-singh.jpg';
}

function guest_media_path(?string $imagePath, string $fallback): string
{
    $imagePath = trim((string) $imagePath);
    if ($imagePath === '') {
        return $fallback;
    }
    $normalized = str_replace('\\', '/', $imagePath);
    if (strpos($normalized, '/') === false) {
        return $normalized;
    }
    return '../' . ltrim($normalized, '/');
}

function find_user_by_identifier(string $identifier): ?array
{
    $statement = db()->prepare(
        'SELECT * FROM users WHERE user_id = :identifier OR email = :identifier LIMIT 1'
    );
    $statement->execute(['identifier' => $identifier]);
    $user = $statement->fetch();

    return $user === false ? null : $user;
}

function create_password_reset_request(int $userId, string $tokenHash, string $expiresAt): bool
{
    $statement = db()->prepare(
        'INSERT INTO password_resets (user_id, token_hash, expires_at) VALUES (:user_id, :token_hash, :expires_at)'
    );

    return $statement->execute([
        'user_id' => $userId,
        'token_hash' => $tokenHash,
        'expires_at' => $expiresAt,
    ]);
}

function find_password_reset_by_token(string $token): ?array
{
    $tokenHash = hash('sha256', $token);
    $statement = db()->prepare(
        'SELECT pr.*, u.user_id AS user_login_id, u.email AS user_email, u.role AS user_role
         FROM password_resets pr
         JOIN users u ON u.id = pr.user_id
         WHERE pr.token_hash = :token_hash
         LIMIT 1'
    );
    $statement->execute(['token_hash' => $tokenHash]);
    $reset = $statement->fetch();

    if ($reset === false) {
        return null;
    }

    if ($reset['used_at'] !== null || strtotime($reset['expires_at']) < time()) {
        return null;
    }

    return $reset;
}

function mark_password_reset_as_used(int $resetId): bool
{
    $statement = db()->prepare(
        'UPDATE password_resets SET used_at = NOW() WHERE id = :id'
    );

    return $statement->execute(['id' => $resetId]);
}

function update_user_password(int $userId, string $password): bool
{
    $statement = db()->prepare('UPDATE users SET password = :password WHERE id = :id');
    return $statement->execute(['password' => $password, 'id' => $userId]);
}

function movie_schedule_catalog(): array
{
    return [
        [
            'city' => 'Ahmedabad',
            'venues' => [
                [
                    'name' => 'Cinepolis: Alpha One',
                    'area' => 'Vastrapur, Ahmedabad',
                    'features' => ['Food Court', 'Parking', 'Dolby Atmos'],
                    'screens' => [
                        ['type' => 'Standard 4K', 'times' => ['10:15 AM', '01:35 PM', '04:45 PM', '07:30 PM']],
                        ['type' => 'XL 4K', 'times' => ['11:20 AM', '02:40 PM', '06:10 PM', '09:20 PM']],
                        ['type' => 'ScreenX', 'times' => ['12:05 PM', '03:25 PM', '06:50 PM', '10:05 PM']],
                    ],
                ],
                [
                    'name' => 'PVR: Acropolis Mall',
                    'area' => 'Thaltej, Ahmedabad',
                    'features' => ['Recliner', 'Laser Projection', 'Parking'],
                    'screens' => [
                        ['type' => 'Classic', 'times' => ['11:00 AM', '02:20 PM', '06:00 PM', '09:40 PM']],
                        ['type' => 'Prime', 'times' => ['09:50 AM', '01:10 PM', '04:30 PM', '08:00 PM']],
                        ['type' => 'Director\'s Cut', 'times' => ['12:30 PM', '03:50 PM', '07:10 PM', '10:25 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Mumbai',
            'venues' => [
                [
                    'name' => 'INOX: R-City',
                    'area' => 'Ghatkopar, Mumbai',
                    'features' => ['Premium Seats', 'Dolby Atmos', 'Parking'],
                    'screens' => [
                        ['type' => 'Insignia', 'times' => ['10:30 AM', '01:50 PM', '05:20 PM', '08:45 PM']],
                        ['type' => 'BigPix', 'times' => ['11:10 AM', '02:35 PM', '06:05 PM', '09:35 PM']],
                        ['type' => 'Premiere', 'times' => ['12:15 PM', '03:40 PM', '07:00 PM', '10:15 PM']],
                    ],
                ],
                [
                    'name' => 'PVR: Jio World Drive',
                    'area' => 'BKC, Mumbai',
                    'features' => ['Lounge', 'Valet', 'Gourmet Counter'],
                    'screens' => [
                        ['type' => 'IMAX', 'times' => ['09:45 AM', '01:15 PM', '04:40 PM', '08:10 PM']],
                        ['type' => '4DX', 'times' => ['10:55 AM', '02:25 PM', '05:50 PM', '09:15 PM']],
                        ['type' => 'Prime', 'times' => ['12:05 PM', '03:30 PM', '06:55 PM', '10:20 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Pune',
            'venues' => [
                [
                    'name' => 'PVR: Phoenix Marketcity',
                    'area' => 'Viman Nagar, Pune',
                    'features' => ['Food Court', 'Valet', 'Premium Lobby'],
                    'screens' => [
                        ['type' => 'IMAX', 'times' => ['09:50 AM', '01:10 PM', '04:20 PM', '07:55 PM']],
                        ['type' => '4DX', 'times' => ['11:05 AM', '02:30 PM', '05:45 PM', '09:10 PM']],
                        ['type' => 'Classic', 'times' => ['12:20 PM', '03:45 PM', '07:05 PM', '10:30 PM']],
                    ],
                ],
                [
                    'name' => 'Cinepolis: Seasons Mall',
                    'area' => 'Hadapsar, Pune',
                    'features' => ['Parking', 'Cafe', 'Laser Projection'],
                    'screens' => [
                        ['type' => 'Laser XL', 'times' => ['10:20 AM', '01:40 PM', '05:00 PM', '08:25 PM']],
                        ['type' => 'Standard', 'times' => ['11:35 AM', '02:55 PM', '06:15 PM', '09:35 PM']],
                        ['type' => 'VIP', 'times' => ['12:40 PM', '04:00 PM', '07:20 PM', '10:40 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Delhi',
            'venues' => [
                [
                    'name' => 'Cinepolis: DLF Avenue',
                    'area' => 'Saket, Delhi',
                    'features' => ['Lounge', 'Parking', 'Dolby 7.1'],
                    'screens' => [
                        ['type' => 'Laser 4K', 'times' => ['10:40 AM', '02:00 PM', '05:30 PM', '09:10 PM']],
                        ['type' => 'VIP', 'times' => ['11:25 AM', '02:50 PM', '06:20 PM', '09:45 PM']],
                        ['type' => 'ScreenX', 'times' => ['12:10 PM', '03:35 PM', '07:00 PM', '10:25 PM']],
                    ],
                ],
                [
                    'name' => 'PVR: Select Citywalk',
                    'area' => 'Saket, Delhi',
                    'features' => ['IMAX Lobby', 'Recliners', 'Dining'],
                    'screens' => [
                        ['type' => 'IMAX', 'times' => ['09:30 AM', '12:55 PM', '04:25 PM', '08:00 PM']],
                        ['type' => '4DX', 'times' => ['10:50 AM', '02:15 PM', '05:40 PM', '09:05 PM']],
                        ['type' => 'Prime', 'times' => ['12:00 PM', '03:25 PM', '06:50 PM', '10:15 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Bangalore',
            'venues' => [
                [
                    'name' => 'PVR: Orion Mall',
                    'area' => 'Rajajinagar, Bangalore',
                    'features' => ['Parking', 'Lounge', 'Snacks Bar'],
                    'screens' => [
                        ['type' => 'IMAX', 'times' => ['09:40 AM', '01:05 PM', '04:35 PM', '08:05 PM']],
                        ['type' => 'Gold', 'times' => ['10:55 AM', '02:20 PM', '05:50 PM', '09:20 PM']],
                        ['type' => 'Classic', 'times' => ['12:10 PM', '03:35 PM', '07:00 PM', '10:30 PM']],
                    ],
                ],
                [
                    'name' => 'INOX: Mantri Square',
                    'area' => 'Malleshwaram, Bangalore',
                    'features' => ['MX4D', 'Parking', 'Cafe'],
                    'screens' => [
                        ['type' => 'Laser', 'times' => ['10:10 AM', '01:30 PM', '04:55 PM', '08:15 PM']],
                        ['type' => 'MX4D', 'times' => ['11:15 AM', '02:45 PM', '06:05 PM', '09:30 PM']],
                        ['type' => 'Club', 'times' => ['12:25 PM', '03:55 PM', '07:15 PM', '10:40 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Hyderabad',
            'venues' => [
                [
                    'name' => 'AMB Cinemas',
                    'area' => 'Gachibowli, Hyderabad',
                    'features' => ['Luxury Lounge', 'Valet', 'Dolby Atmos'],
                    'screens' => [
                        ['type' => 'Onyx LED', 'times' => ['10:00 AM', '01:25 PM', '04:50 PM', '08:20 PM']],
                        ['type' => 'Laser XL', 'times' => ['11:20 AM', '02:45 PM', '06:10 PM', '09:35 PM']],
                        ['type' => 'Platinum', 'times' => ['12:35 PM', '04:00 PM', '07:25 PM', '10:50 PM']],
                    ],
                ],
                [
                    'name' => 'PVR: Next Galleria',
                    'area' => 'Panjagutta, Hyderabad',
                    'features' => ['Food Court', 'Recliner', 'Parking'],
                    'screens' => [
                        ['type' => 'IMAX', 'times' => ['09:35 AM', '01:00 PM', '04:30 PM', '08:00 PM']],
                        ['type' => '4DX', 'times' => ['10:45 AM', '02:15 PM', '05:40 PM', '09:05 PM']],
                        ['type' => 'Classic', 'times' => ['12:00 PM', '03:30 PM', '06:55 PM', '10:20 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Chennai',
            'venues' => [
                [
                    'name' => 'SPI: Palazzo',
                    'area' => 'Vadapalani, Chennai',
                    'features' => ['Luxury Seating', 'Cafe', 'Parking'],
                    'screens' => [
                        ['type' => 'Luxe', 'times' => ['10:05 AM', '01:30 PM', '05:00 PM', '08:30 PM']],
                        ['type' => 'Laser', 'times' => ['11:15 AM', '02:40 PM', '06:05 PM', '09:30 PM']],
                        ['type' => 'Elite', 'times' => ['12:25 PM', '03:50 PM', '07:15 PM', '10:40 PM']],
                    ],
                ],
                [
                    'name' => 'PVR: Heritage RSL',
                    'area' => 'Anna Salai, Chennai',
                    'features' => ['4DX', 'Dining', 'Parking'],
                    'screens' => [
                        ['type' => 'Director\'s Cut', 'times' => ['09:50 AM', '01:20 PM', '04:45 PM', '08:10 PM']],
                        ['type' => '4DX', 'times' => ['11:00 AM', '02:30 PM', '05:55 PM', '09:20 PM']],
                        ['type' => 'Classic', 'times' => ['12:10 PM', '03:40 PM', '07:05 PM', '10:30 PM']],
                    ],
                ],
            ],
        ],
        [
            'city' => 'Kolkata',
            'venues' => [
                [
                    'name' => 'INOX: South City',
                    'area' => 'Jadavpur, Kolkata',
                    'features' => ['Cafe', 'Parking', 'Premium Seats'],
                    'screens' => [
                        ['type' => 'Laserplex', 'times' => ['10:25 AM', '01:50 PM', '05:15 PM', '08:40 PM']],
                        ['type' => 'Insignia', 'times' => ['11:30 AM', '02:55 PM', '06:20 PM', '09:45 PM']],
                        ['type' => 'Club', 'times' => ['12:35 PM', '04:00 PM', '07:25 PM', '10:50 PM']],
                    ],
                ],
                [
                    'name' => 'PVR: Avani Riverside',
                    'area' => 'Howrah, Kolkata',
                    'features' => ['IMAX Lobby', 'Dining', 'Parking'],
                    'screens' => [
                        ['type' => 'IMAX', 'times' => ['09:45 AM', '01:10 PM', '04:40 PM', '08:10 PM']],
                        ['type' => '4DX', 'times' => ['10:55 AM', '02:25 PM', '05:50 PM', '09:15 PM']],
                        ['type' => 'Classic', 'times' => ['12:05 PM', '03:35 PM', '07:00 PM', '10:25 PM']],
                    ],
                ],
            ],
        ],
    ];
}

function movie_show_label_for_time(string $time): string
{
    $timestamp = strtotime($time);
    if ($timestamp === false) {
        return 'Regular Show';
    }

    $hour = (int) date('G', $timestamp);
    if ($hour < 12) {
        return 'Morning Show';
    }
    if ($hour < 16) {
        return 'Matinee Show';
    }
    if ($hour < 20) {
        return 'Evening Show';
    }
    return 'Night Show';
}

function catalog_venue_details(?string $city, string $venue): array
{
    foreach (movie_schedule_catalog() as $cityBlock) {
        if ($city !== null && $city !== '' && strcasecmp((string) $cityBlock['city'], $city) !== 0) {
            continue;
        }

        foreach ($cityBlock['venues'] as $venueBlock) {
            if (strcasecmp((string) $venueBlock['name'], $venue) === 0) {
                return $venueBlock;
            }
        }
    }

    return [
        'name' => $venue,
        'area' => $city ?: 'Multiple locations',
        'features' => [],
        'screens' => [],
    ];
}

function default_movie_schedules_from_catalog(): array
{
    $schedules = [];
    foreach (movie_schedule_catalog() as $cityBlock) {
        foreach ($cityBlock['venues'] as $venueBlock) {
            foreach ($venueBlock['screens'] as $screenBlock) {
                foreach ($screenBlock['times'] as $index => $time) {
                    $schedules[] = [
                        'city' => (string) $cityBlock['city'],
                        'venue' => (string) $venueBlock['name'],
                        'screen_type' => (string) $screenBlock['type'],
                        'show_time' => (string) $time,
                        'display_order' => $index,
                    ];
                }
            }
        }
    }

    return $schedules;
}

function normalize_movie_schedules(array $schedules): array
{
    $normalized = [];
    $seen = [];

    foreach ($schedules as $index => $schedule) {
        if (!is_array($schedule)) {
            continue;
        }

        $city = trim((string) ($schedule['city'] ?? ''));
        $venue = trim((string) ($schedule['venue'] ?? ''));
        $screenType = trim((string) ($schedule['screen_type'] ?? ''));
        $showTime = trim((string) ($schedule['show_time'] ?? ''));

        if ($city === '' || $venue === '' || $screenType === '' || $showTime === '') {
            continue;
        }

        $signature = strtolower($city . '|' . $venue . '|' . $screenType . '|' . $showTime);
        if (isset($seen[$signature])) {
            continue;
        }

        $seen[$signature] = true;
        $normalized[] = [
            'city' => $city,
            'venue' => $venue,
            'screen_type' => $screenType,
            'show_time' => $showTime,
            'display_order' => count($normalized) + (is_numeric($index) ? 0 : 0),
        ];
    }

    return $normalized;
}

function fetch_movies(?int $limit = null, bool $activeOnly = true): array
{
    $sql = 'SELECT * FROM movies';
    if ($activeOnly) {
        $sql .= ' WHERE status = "active"';
    }
    $sql .= ' ORDER BY created_at DESC, release_date DESC';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return db()->query($sql)->fetchAll();
}

function fetch_events(?int $limit = null, bool $activeOnly = true): array
{
    $sql = 'SELECT * FROM events';
    if ($activeOnly) {
        $sql .= ' WHERE status = "active"';
    }
    $sql .= ' ORDER BY event_date ASC, event_time ASC';
    if ($limit !== null) {
        $sql .= ' LIMIT ' . (int) $limit;
    }
    return db()->query($sql)->fetchAll();
}

function fetch_home_trending(int $movieLimit = 2, int $eventLimit = 2): array
{
    $items = [];
    foreach (fetch_movies($movieLimit) as $movie) {
        $movie['item_type'] = 'movie';
        $items[] = $movie;
    }
    foreach (fetch_events($eventLimit) as $event) {
        $event['item_type'] = 'event';
        $items[] = $event;
    }
    return $items;
}

function fetch_users(bool $includeAdmins = true): array
{
    $sql = 'SELECT * FROM users';
    if (!$includeAdmins) {
        $sql .= ' WHERE role <> "admin"';
    }
    $sql .= ' ORDER BY created_at DESC, id DESC';
    return db()->query($sql)->fetchAll();
}

function find_user_for_login(string $userId): ?array
{
    $statement = db()->prepare('SELECT * FROM users WHERE user_id = :user_id LIMIT 1');
    $statement->execute(['user_id' => trim($userId)]);
    $user = $statement->fetch();
    return $user ?: null;
}

function find_user_by_email(string $email): ?array
{
    $statement = db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
    $statement->execute(['email' => trim($email)]);
    $user = $statement->fetch();
    return $user ?: null;
}

function find_user_by_numeric_id(int $id): ?array
{
    $statement = db()->prepare('SELECT * FROM users WHERE id = :id LIMIT 1');
    $statement->execute(['id' => $id]);
    $user = $statement->fetch();
    return $user ?: null;
}

function user_exists(string $userId, string $email): bool
{
    $statement = db()->prepare('SELECT COUNT(*) FROM users WHERE user_id = :user_id OR email = :email');
    $statement->execute(['user_id' => trim($userId), 'email' => trim($email)]);
    return (int) $statement->fetchColumn() > 0;
}

function create_registered_user(array $payload): int
{
    $pdo = db();
    $statement = $pdo->prepare(
        'INSERT INTO users
            (user_id, full_name, email, password, role, status, phone, dob, gender, country, interests, bio, photo_path)
         VALUES
            (:user_id, :full_name, :email, :password, :role, :status, :phone, :dob, :gender, :country, :interests, :bio, :photo_path)'
    );
    $statement->execute([
        'user_id' => trim((string) $payload['user_id']),
        'full_name' => trim((string) $payload['full_name']),
        'email' => trim((string) $payload['email']),
        'password' => (string) $payload['password'],
        'role' => 'normal',
        'status' => 'active',
        'phone' => trim((string) ($payload['phone'] ?? '')) ?: null,
        'dob' => trim((string) ($payload['dob'] ?? '')) ?: null,
        'gender' => trim((string) ($payload['gender'] ?? '')) ?: null,
        'country' => trim((string) ($payload['country'] ?? '')) ?: null,
        'interests' => trim((string) ($payload['interests'] ?? '')) ?: null,
        'bio' => trim((string) ($payload['bio'] ?? '')) ?: null,
        'photo_path' => trim((string) ($payload['photo_path'] ?? '')) ?: null,
    ]);
    return (int) $pdo->lastInsertId();
}

function is_user_email_verified(array $user): bool
{
    return trim((string) ($user['email_verified_at'] ?? '')) !== '';
}

function generate_email_verification(int $userId, int $ttlHours = 24): ?string
{
    if ($userId <= 0) {
        return null;
    }

    $token = bin2hex(random_bytes(32));
    $tokenHash = hash('sha256', $token);
    $expiresAt = date('Y-m-d H:i:s', strtotime('+' . $ttlHours . ' hours'));

    $statement = db()->prepare(
        'UPDATE users
         SET verification_token_hash = :token_hash, verification_token_expires_at = :expires_at
         WHERE id = :id'
    );
    $statement->execute([
        'token_hash' => $tokenHash,
        'expires_at' => $expiresAt,
        'id' => $userId,
    ]);

    return $token;
}

function send_email_verification_message(array $user, string $token): array
{
    $verificationLink = ticketvarse_app_url() . '/verify_email.php?token=' . rawurlencode($token);
    $subject = 'Verify your Ticketvarse email address';
    $body = "Hello " . trim((string) ($user['full_name'] ?? $user['user_id'])) . ",\n\n"
        . "Please verify your email address by opening the link below:\n"
        . $verificationLink . "\n\n"
        . "This link will expire in 24 hours.\n\n"
        . "If you did not create this account, you can ignore this email.\n";

    return ticketvarse_send_mail((string) $user['email'], $subject, $body);
}

function send_verification_for_user(array $user): array
{
    $userId = (int) ($user['id'] ?? 0);
    if ($userId <= 0) {
        throw new RuntimeException('Invalid user for verification.');
    }

    $token = generate_email_verification($userId);
    if ($token === null) {
        throw new RuntimeException('Could not generate verification token.');
    }

    return send_email_verification_message($user, $token);
}

function find_user_by_verification_token(string $token): ?array
{
    $statement = db()->prepare(
        'SELECT * FROM users
         WHERE verification_token_hash = :token_hash
           AND verification_token_expires_at IS NOT NULL
           AND verification_token_expires_at >= NOW()
         LIMIT 1'
    );
    $statement->execute(['token_hash' => hash('sha256', $token)]);
    $user = $statement->fetch();
    return $user ?: null;
}

function mark_user_email_verified(int $userId): void
{
    $statement = db()->prepare(
        'UPDATE users
         SET email_verified_at = NOW(), verification_token_hash = NULL, verification_token_expires_at = NULL
         WHERE id = :id'
    );
    $statement->execute(['id' => $userId]);
}

function update_user_profile(int $id, array $payload): void
{
    $statement = db()->prepare('UPDATE users SET full_name = :full_name, email = :email, phone = :phone, dob = :dob, gender = :gender, country = :country, interests = :interests, bio = :bio WHERE id = :id');
    $statement->execute([
        'id' => $id,
        'full_name' => trim((string) $payload['full_name']),
        'email' => trim((string) $payload['email']),
        'phone' => trim((string) ($payload['phone'] ?? '')) ?: null,
        'dob' => trim((string) ($payload['dob'] ?? '')) ?: null,
        'gender' => trim((string) ($payload['gender'] ?? '')) ?: null,
        'country' => trim((string) ($payload['country'] ?? '')) ?: null,
        'interests' => trim((string) ($payload['interests'] ?? '')) ?: null,
        'bio' => trim((string) ($payload['bio'] ?? '')) ?: null,
    ]);
}

function fetch_user_bookings(int $userId): array
{
    $statement = db()->prepare('SELECT * FROM bookings WHERE user_id = :user_id ORDER BY created_at DESC, id DESC');
    $statement->execute(['user_id' => $userId]);
    return $statement->fetchAll();
}

function fetch_all_bookings(): array
{
    $sql = 'SELECT b.*, u.full_name, u.user_id AS login_user_id FROM bookings b INNER JOIN users u ON u.id = b.user_id ORDER BY b.created_at DESC, b.id DESC';
    return db()->query($sql)->fetchAll();
}

function fetch_user_payment_methods(int $userId): array
{
    $statement = db()->prepare('SELECT * FROM payment_methods WHERE user_id = :user_id ORDER BY is_default DESC, created_at DESC');
    $statement->execute(['user_id' => $userId]);
    return $statement->fetchAll();
}

function fetch_booked_seats(string $showName, string $bookingDate, string $bookingTime, string $venue): array
{
    $statement = db()->prepare('SELECT seats FROM bookings WHERE show_name = :show_name AND booking_date = :booking_date AND booking_time = :booking_time AND venue = :venue AND booking_status IN ("confirmed", "upcoming")');
    $statement->execute([
        'show_name' => trim($showName),
        'booking_date' => trim($bookingDate),
        'booking_time' => trim($bookingTime),
        'venue' => trim($venue),
    ]);
    $booked = [];
    foreach ($statement->fetchAll() as $row) {
        foreach (array_map('trim', explode(',', (string) $row['seats'])) as $seat) {
            if ($seat !== '') {
                $booked[] = $seat;
            }
        }
    }
    return array_values(array_unique($booked));
}

function fetch_movie_schedules_by_title(string $title): array
{
    $title = trim($title);
    if ($title === '') {
        return default_movie_schedules_from_catalog();
    }

    $statement = db()->prepare(
        'SELECT ms.city, ms.venue, ms.screen_type, ms.show_time, ms.display_order
         FROM movie_schedules ms
         INNER JOIN movies m ON m.id = ms.movie_id
         WHERE LOWER(m.title) = LOWER(:title)
         ORDER BY ms.display_order ASC, ms.city ASC, ms.venue ASC, ms.show_time ASC'
    );
    $statement->execute(['title' => $title]);
    $schedules = $statement->fetchAll();

    return $schedules ?: default_movie_schedules_from_catalog();
}

function save_payment_method(int $userId, string $methodType, string $label, string $details, bool $setDefault = false): void
{
    $pdo = db();
    if ($setDefault) {
        $reset = $pdo->prepare('UPDATE payment_methods SET is_default = 0 WHERE user_id = :user_id');
        $reset->execute(['user_id' => $userId]);
    }
    $statement = $pdo->prepare('INSERT INTO payment_methods (user_id, method_type, label, details, is_default) VALUES (:user_id, :method_type, :label, :details, :is_default)');
    $statement->execute(['user_id' => $userId, 'method_type' => $methodType, 'label' => $label, 'details' => $details, 'is_default' => $setDefault ? 1 : 0]);
}

function create_booking_with_payment(int $userId, array $bookingPayload, array $paymentPayload): int
{
    $pdo = db();
    $pdo->beginTransaction();
    try {
        $bookingStatement = $pdo->prepare('INSERT INTO bookings (user_id, booking_type, show_name, venue, city, booking_date, booking_time, seats, seat_count, subtotal, fee, total_amount, payment_status, booking_status) VALUES (:user_id, :booking_type, :show_name, :venue, :city, :booking_date, :booking_time, :seats, :seat_count, :subtotal, :fee, :total_amount, :payment_status, :booking_status)');
        $bookingStatement->execute(['user_id' => $userId, 'booking_type' => $bookingPayload['booking_type'], 'show_name' => $bookingPayload['show_name'], 'venue' => $bookingPayload['venue'], 'city' => $bookingPayload['city'], 'booking_date' => $bookingPayload['booking_date'], 'booking_time' => $bookingPayload['booking_time'], 'seats' => $bookingPayload['seats'], 'seat_count' => $bookingPayload['seat_count'], 'subtotal' => $bookingPayload['subtotal'], 'fee' => $bookingPayload['fee'], 'total_amount' => $bookingPayload['total_amount'], 'payment_status' => 'paid', 'booking_status' => 'confirmed']);
        $bookingId = (int) $pdo->lastInsertId();
        $paymentStatement = $pdo->prepare('INSERT INTO payments (booking_id, user_id, method_type, payment_label, amount, payment_status) VALUES (:booking_id, :user_id, :method_type, :payment_label, :amount, :payment_status)');
        $paymentStatement->execute(['booking_id' => $bookingId, 'user_id' => $userId, 'method_type' => $paymentPayload['method_type'], 'payment_label' => $paymentPayload['payment_label'], 'amount' => $bookingPayload['total_amount'], 'payment_status' => 'paid']);
        if (!empty($paymentPayload['save_method'])) {
            save_payment_method($userId, $paymentPayload['method_type'], $paymentPayload['payment_label'], $paymentPayload['details'], !empty($paymentPayload['set_default']));
        }
        $pdo->commit();
        return $bookingId;
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        throw $exception;
    }
}

function toggle_record_status(string $type, int $id): void
{
    $allowedTables = ['movie' => 'movies', 'event' => 'events', 'user' => 'users'];
    if (!isset($allowedTables[$type])) {
        return;
    }
    $table = $allowedTables[$type];
    $statement = db()->prepare("UPDATE {$table} SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = :id");
    $statement->execute(['id' => $id]);
}

function store_uploaded_image(array $file, string $prefix): ?string
{
    if (!isset($file['error']) || (int) $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    $extension = strtolower(pathinfo((string) $file['name'], PATHINFO_EXTENSION));
    $safeExtension = preg_replace('/[^a-z0-9]/', '', $extension) ?: 'jpg';
    $fileName = uniqid($prefix . '_', true) . '.' . $safeExtension;
    $uploadDirectory = dirname(__DIR__) . '/uploads';
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0777, true);
    }
    $destination = $uploadDirectory . '/' . $fileName;
    if (!move_uploaded_file((string) $file['tmp_name'], $destination)) {
        return null;
    }
    return 'uploads/' . $fileName;
}

function replace_movie_schedules(int $movieId, array $schedules): void
{
    $normalized = normalize_movie_schedules($schedules);
    if ($movieId <= 0) {
        return;
    }

    $pdo = db();
    $deleteStatement = $pdo->prepare('DELETE FROM movie_schedules WHERE movie_id = :movie_id');
    $deleteStatement->execute(['movie_id' => $movieId]);

    if ($normalized === []) {
        return;
    }

    $insertStatement = $pdo->prepare(
        'INSERT INTO movie_schedules (movie_id, city, venue, screen_type, show_time, display_order)
         VALUES (:movie_id, :city, :venue, :screen_type, :show_time, :display_order)'
    );

    foreach ($normalized as $order => $schedule) {
        $insertStatement->execute([
            'movie_id' => $movieId,
            'city' => $schedule['city'],
            'venue' => $schedule['venue'],
            'screen_type' => $schedule['screen_type'],
            'show_time' => $schedule['show_time'],
            'display_order' => $order,
        ]);
    }
}

function create_movie(array $payload): int
{
    $pdo = db();
    $statement = $pdo->prepare('INSERT INTO movies (title, genre, release_date, duration_minutes, language, description, ticket_price, shows_per_day, image_path, status) VALUES (:title, :genre, :release_date, :duration_minutes, :language, :description, :ticket_price, :shows_per_day, :image_path, :status)');
    $statement->execute(['title' => trim((string) $payload['title']), 'genre' => trim((string) $payload['genre']), 'release_date' => (string) $payload['release_date'], 'duration_minutes' => (int) $payload['duration_minutes'], 'language' => trim((string) $payload['language']), 'description' => trim((string) ($payload['description'] ?? '')), 'ticket_price' => (float) $payload['ticket_price'], 'shows_per_day' => (int) $payload['shows_per_day'], 'image_path' => $payload['image_path'] ?: default_movie_image(), 'status' => 'active']);
    $movieId = (int) $pdo->lastInsertId();
    replace_movie_schedules($movieId, (array) ($payload['schedules'] ?? []));
    return $movieId;
}

function create_event(array $payload): void
{
    $statement = db()->prepare('INSERT INTO events (name, category, event_date, event_time, location, description, ticket_price, available_seats, image_path, status) VALUES (:name, :category, :event_date, :event_time, :location, :description, :ticket_price, :available_seats, :image_path, :status)');
    $statement->execute(['name' => trim((string) $payload['name']), 'category' => trim((string) $payload['category']), 'event_date' => (string) $payload['event_date'], 'event_time' => (string) $payload['event_time'], 'location' => trim((string) $payload['location']), 'description' => trim((string) ($payload['description'] ?? '')), 'ticket_price' => (float) $payload['ticket_price'], 'available_seats' => (int) $payload['available_seats'], 'image_path' => $payload['image_path'] ?: default_event_image(), 'status' => 'active']);
}

function fetch_movie_schedules_for_movie(int $movieId): array
{
    if ($movieId <= 0) {
        return [];
    }

    $statement = db()->prepare(
        'SELECT id, movie_id, city, venue, screen_type, show_time, display_order
         FROM movie_schedules
         WHERE movie_id = :movie_id
         ORDER BY display_order ASC, city ASC, venue ASC, show_time ASC'
    );
    $statement->execute(['movie_id' => $movieId]);
    return $statement->fetchAll();
}

function fetch_movie_schedules_grouped_by_movie(array $movieIds): array
{
    $movieIds = array_values(array_filter(array_map('intval', $movieIds), static function (int $id): bool {
        return $id > 0;
    }));
    if ($movieIds === []) {
        return [];
    }

    $placeholders = implode(', ', array_fill(0, count($movieIds), '?'));
    $statement = db()->prepare(
        "SELECT id, movie_id, city, venue, screen_type, show_time, display_order
         FROM movie_schedules
         WHERE movie_id IN ($placeholders)
         ORDER BY movie_id ASC, display_order ASC, city ASC, venue ASC, show_time ASC"
    );
    $statement->execute($movieIds);

    $grouped = [];
    foreach ($statement->fetchAll() as $schedule) {
        $grouped[(int) $schedule['movie_id']][] = $schedule;
    }

    return $grouped;
}

function sync_movie_shows_per_day(int $movieId): void
{
    if ($movieId <= 0) {
        return;
    }

    $countStatement = db()->prepare('SELECT COUNT(*) FROM movie_schedules WHERE movie_id = :movie_id');
    $countStatement->execute(['movie_id' => $movieId]);
    $showCount = max(1, (int) $countStatement->fetchColumn());

    $updateStatement = db()->prepare('UPDATE movies SET shows_per_day = :shows_per_day WHERE id = :id');
    $updateStatement->execute(['shows_per_day' => $showCount, 'id' => $movieId]);
}

function add_movie_schedule(int $movieId, array $schedule): void
{
    if ($movieId <= 0) {
        return;
    }

    $normalized = normalize_movie_schedules([$schedule]);
    if ($normalized === []) {
        return;
    }

    $schedule = $normalized[0];
    $existsStatement = db()->prepare(
        'SELECT COUNT(*) FROM movie_schedules
         WHERE movie_id = :movie_id AND LOWER(city) = LOWER(:city) AND LOWER(venue) = LOWER(:venue)
           AND LOWER(screen_type) = LOWER(:screen_type) AND LOWER(show_time) = LOWER(:show_time)'
    );
    $existsStatement->execute([
        'movie_id' => $movieId,
        'city' => $schedule['city'],
        'venue' => $schedule['venue'],
        'screen_type' => $schedule['screen_type'],
        'show_time' => $schedule['show_time'],
    ]);
    if ((int) $existsStatement->fetchColumn() > 0) {
        sync_movie_shows_per_day($movieId);
        return;
    }

    $orderStatement = db()->prepare('SELECT COALESCE(MAX(display_order), -1) + 1 FROM movie_schedules WHERE movie_id = :movie_id');
    $orderStatement->execute(['movie_id' => $movieId]);
    $displayOrder = (int) $orderStatement->fetchColumn();

    $insertStatement = db()->prepare(
        'INSERT INTO movie_schedules (movie_id, city, venue, screen_type, show_time, display_order)
         VALUES (:movie_id, :city, :venue, :screen_type, :show_time, :display_order)'
    );
    $insertStatement->execute([
        'movie_id' => $movieId,
        'city' => $schedule['city'],
        'venue' => $schedule['venue'],
        'screen_type' => $schedule['screen_type'],
        'show_time' => $schedule['show_time'],
        'display_order' => $displayOrder,
    ]);

    sync_movie_shows_per_day($movieId);
}

function delete_movie_schedule(int $movieId, int $scheduleId): void
{
    if ($movieId <= 0 || $scheduleId <= 0) {
        return;
    }

    $deleteStatement = db()->prepare('DELETE FROM movie_schedules WHERE id = :id AND movie_id = :movie_id');
    $deleteStatement->execute(['id' => $scheduleId, 'movie_id' => $movieId]);
    sync_movie_shows_per_day($movieId);
}


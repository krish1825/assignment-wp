<?php
session_start();

require_once __DIR__ . '/../includes/content_repository.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'normal') {
    header('Location: Sign_in.php?error=Please%20sign%20in%20as%20normal%20user');
    exit;
}

$user = find_user_for_login((string) ($_SESSION['user_id'] ?? ''));
if (!$user || ($user['status'] ?? 'active') !== 'active') {
    session_unset();
    session_destroy();
    header('Location: Sign_in.php?error=Your%20account%20is%20inactive');
    exit;
}

$savedMethods = fetch_user_payment_methods((int) $user['id']);
$show = trim((string) ($_REQUEST['show'] ?? ''));
$date = trim((string) ($_REQUEST['date'] ?? ''));
$time = trim((string) ($_REQUEST['time'] ?? ''));
$venue = trim((string) ($_REQUEST['venue'] ?? ''));
$city = trim((string) ($_REQUEST['city'] ?? ''));
$seats = trim((string) ($_REQUEST['seats'] ?? ''));
$subtotal = (float) ($_REQUEST['subtotal'] ?? 0);
$fee = (float) ($_REQUEST['fee'] ?? 0);
$total = (float) ($_REQUEST['total'] ?? 0);
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = trim((string) ($_POST['payment_method'] ?? 'card'));
    $paymentLabel = '';
    $details = '';
    if ($method === 'card') {
        $cardNumber = preg_replace('/\s+/', '', (string) ($_POST['card_number'] ?? ''));
        $cardName = trim((string) ($_POST['card_name'] ?? ''));
        if (!preg_match('/^[0-9]{16}$/', $cardNumber) || $cardName === '') {
            $error = 'Enter valid card details.';
        }
        $paymentLabel = 'Card ending ' . substr($cardNumber, -4);
        $details = $cardName;
    } elseif ($method === 'upi') {
        $upiId = trim((string) ($_POST['upi_id'] ?? ''));
        if ($upiId === '') {
            $error = 'Enter a valid UPI ID.';
        }
        $paymentLabel = 'UPI - ' . $upiId;
        $details = $upiId;
    } elseif ($method === 'netbanking') {
        $bank = trim((string) ($_POST['bank_name'] ?? ''));
        if ($bank === '') {
            $error = 'Select a bank to continue.';
        }
        $paymentLabel = 'Net Banking - ' . $bank;
        $details = $bank;
    } else {
        $wallet = trim((string) ($_POST['wallet_name'] ?? ''));
        if ($wallet === '') {
            $error = 'Select a wallet to continue.';
        }
        $paymentLabel = 'Wallet - ' . $wallet;
        $details = $wallet;
    }

    if ($show === '' || $date === '' || $time === '' || $venue === '' || $seats === '' || $total <= 0) {
        $error = 'Your booking summary is incomplete. Please select seats again.';
    }

    if ($error === '') {
        $bookingType = 'movie';
        foreach (fetch_events(null, false) as $event) {
            if (strcasecmp((string) $event['name'], $show) === 0) {
                $bookingType = 'event';
                break;
            }
        }
        if ($city === '' && str_contains($venue, ',')) {
            $city = trim((string) strrchr($venue, ','), ', ');
        }
        $bookingId = create_booking_with_payment((int) $user['id'], [
            'booking_type' => $bookingType,
            'show_name' => $show,
            'venue' => $venue,
            'city' => $city,
            'booking_date' => $date,
            'booking_time' => $time,
            'seats' => $seats,
            'seat_count' => count(array_filter(array_map('trim', explode(',', $seats)))),
            'subtotal' => $subtotal,
            'fee' => $fee,
            'total_amount' => $total,
        ], [
            'method_type' => $method,
            'payment_label' => $paymentLabel,
            'details' => $details,
            'save_method' => isset($_POST['save_method']),
            'set_default' => isset($_POST['set_default']),
        ]);
        header('Location: My_Bookings.php?success=' . rawurlencode('Payment successful. Your booking is confirmed.') . '&booking_id=' . (int) $bookingId);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Payment | Ticketvarse</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="payment.css">
</head>
<body>
<header class="navbar"><div class="logo">Ticketvarse</div><nav><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a><a href="profile.php">Profile</a><a href="My_Bookings.php">My Bookings</a></nav></header>
<main class="payment-page">
    <section class="payment-hero"><h1>Complete Your Payment</h1><p>Secure checkout protected with encrypted payment processing.</p><span class="secure-tag">100% Secure Transaction</span></section>
    <section class="payment-layout">
        <div class="payment-panel">
            <h2>Select Payment Method</h2>
            <div class="method-tabs" id="methodTabs"><button class="method-tab active" type="button" data-method="card">Card</button><button class="method-tab" type="button" data-method="upi">UPI</button><button class="method-tab" type="button" data-method="netbanking">Net Banking</button><button class="method-tab" type="button" data-method="wallet">Wallet</button></div>
            <form id="paymentForm" method="post" novalidate>
                <input type="hidden" name="payment_method" id="paymentMethodInput" value="card">
                <input type="hidden" name="show" value="<?= e($show) ?>"><input type="hidden" name="date" value="<?= e($date) ?>"><input type="hidden" name="time" value="<?= e($time) ?>"><input type="hidden" name="venue" value="<?= e($venue) ?>"><input type="hidden" name="city" value="<?= e($city) ?>"><input type="hidden" name="seats" value="<?= e($seats) ?>"><input type="hidden" name="subtotal" value="<?= e((string) $subtotal) ?>"><input type="hidden" name="fee" value="<?= e((string) $fee) ?>"><input type="hidden" name="total" value="<?= e((string) $total) ?>">
                <div id="paymentErrors" class="error-box"<?= $error === '' ? ' style="display:none;"' : '' ?>><?= e($error) ?></div>
                <div class="method-panel active" data-panel="card"><label>Card Number<input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19"></label><label>Cardholder Name<input type="text" name="card_name" placeholder="Enter name on card"></label><div class="split"><label>Expiry<input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5"></label><label>CVV<input type="password" name="card_cvv" placeholder="123" maxlength="3"></label></div></div>
                <div class="method-panel" data-panel="upi"><label>UPI ID<input type="text" name="upi_id" placeholder="name@bank"></label><p class="hint">You will receive a payment request in your UPI app.</p></div>
                <div class="method-panel" data-panel="netbanking"><label>Select Bank<select name="bank_name"><option value="">Choose your bank</option><option value="HDFC Bank">HDFC Bank</option><option value="ICICI Bank">ICICI Bank</option><option value="State Bank of India">State Bank of India</option><option value="Axis Bank">Axis Bank</option></select></label></div>
                <div class="method-panel" data-panel="wallet"><label>Select Wallet<select name="wallet_name"><option value="">Choose wallet</option><option value="Paytm">Paytm</option><option value="PhonePe">PhonePe</option><option value="Amazon Pay">Amazon Pay</option><option value="Mobikwik">Mobikwik</option></select></label></div>
                <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="save_method" value="1" style="width:auto;"> Save this payment method</label>
                <label style="display:flex;align-items:center;gap:8px;"><input type="checkbox" name="set_default" value="1" style="width:auto;"> Set as default</label>
                <button type="submit" class="pay-now-btn">Pay Now</button>
            </form>
        </div>
        <aside class="summary-panel">
            <h2>Order Summary</h2>
            <div class="summary-row"><span>Show</span><strong id="sumShow"><?= e($show ?: '-') ?></strong></div>
            <div class="summary-row"><span>Date</span><strong id="sumDate"><?= e($date ?: '-') ?></strong></div>
            <div class="summary-row"><span>Time</span><strong id="sumTime"><?= e($time ?: '-') ?></strong></div>
            <div class="summary-row"><span>Venue</span><strong id="sumVenue"><?= e($venue ?: '-') ?></strong></div>
            <div class="summary-row"><span>Seats</span><strong id="sumSeats"><?= e($seats ?: '-') ?></strong></div>
            <hr>
            <div class="summary-row"><span>Subtotal</span><strong id="sumSubtotal">INR <?= number_format($subtotal, 0) ?></strong></div>
            <div class="summary-row"><span>Convenience Fee</span><strong id="sumFee">INR <?= number_format($fee, 0) ?></strong></div>
            <div class="summary-row total"><span>Total</span><strong id="sumTotal">INR <?= number_format($total, 0) ?></strong></div>
            <small>By proceeding, you agree to Ticketvarse booking terms.</small>
            <hr>
            <h3>Saved Methods</h3>
            <?php if ($savedMethods === []): ?><small>No saved payment methods yet.</small><?php else: ?><?php foreach ($savedMethods as $method): ?><div class="summary-row"><span><?= e($method['label']) ?></span><strong><?= (int) $method['is_default'] === 1 ? 'Default' : e(ucfirst((string) $method['method_type'])) ?></strong></div><?php endforeach; ?><?php endif; ?>
        </aside>
    </section>
</main>
<footer class="site-footer"><div class="footer-grid"><div class="footer-col"><h4>Ticketvarse</h4><p>Book movie and event tickets with easy checkout and best prices.</p></div><div class="footer-col"><h4>Quick Links</h4><a href="home.php">Home</a><a href="movies.php">Movies</a><a href="events.php">Events</a><a href="Offers.php">Offers</a></div><div class="footer-col"><h4>Support</h4><a href="profile.php">Profile</a><a href="My_Bookings.php">My Bookings</a><a href="sign_up.php">Sign Up</a></div><div class="footer-col"><h4>Contact</h4><p>Email: support@ticketvarse.com</p><p>Phone: +91 90000 00000</p></div></div><div class="footer-note">&copy; 2026 Ticketvarse. All Rights Reserved.</div></footer>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.20.0/dist/jquery.validate.min.js"></script>
<script src="../assets/js/form-validation.js"></script>
<script src="payment.js"></script>
</body>
</html>

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

<main class="payment-page">
    <section class="payment-hero">
        <h1>Complete Your Payment</h1>
        <p>Secure checkout protected with encrypted payment processing.</p>
        <span class="secure-tag">100% Secure Transaction</span>
    </section>

    <section class="payment-layout">
        <div class="payment-panel">
            <h2>Select Payment Method</h2>
            <div class="method-tabs" id="methodTabs">
                <button class="method-tab active" data-method="card">Card</button>
                <button class="method-tab" data-method="upi">UPI</button>
                <button class="method-tab" data-method="netbanking">Net Banking</button>
                <button class="method-tab" data-method="wallet">Wallet</button>
            </div>

            <form id="paymentForm" novalidate>
                <div id="paymentErrors" class="error-box"></div>

                <div class="method-panel active" data-panel="card">
                    <label>Card Number
                        <input type="text" name="card_number" placeholder="1234 5678 9012 3456" maxlength="19">
                    </label>
                    <label>Cardholder Name
                        <input type="text" name="card_name" placeholder="Enter name on card">
                    </label>
                    <div class="split">
                        <label>Expiry
                            <input type="text" name="card_expiry" placeholder="MM/YY" maxlength="5">
                        </label>
                        <label>CVV
                            <input type="password" name="card_cvv" placeholder="123" maxlength="3">
                        </label>
                    </div>
                </div>

                <div class="method-panel" data-panel="upi">
                    <label>UPI ID
                        <input type="text" name="upi_id" placeholder="name@bank">
                    </label>
                    <p class="hint">You will receive a payment request in your UPI app.</p>
                </div>

                <div class="method-panel" data-panel="netbanking">
                    <label>Select Bank
                        <select name="bank_name">
                            <option value="">Choose your bank</option>
                            <option value="HDFC Bank">HDFC Bank</option>
                            <option value="ICICI Bank">ICICI Bank</option>
                            <option value="State Bank of India">State Bank of India</option>
                            <option value="Axis Bank">Axis Bank</option>
                        </select>
                    </label>
                </div>

                <div class="method-panel" data-panel="wallet">
                    <label>Select Wallet
                        <select name="wallet_name">
                            <option value="">Choose wallet</option>
                            <option value="Paytm">Paytm</option>
                            <option value="PhonePe">PhonePe</option>
                            <option value="Amazon Pay">Amazon Pay</option>
                            <option value="Mobikwik">Mobikwik</option>
                        </select>
                    </label>
                </div>

                <button type="submit" class="pay-now-btn">Pay Now</button>
            </form>
        </div>

        <aside class="summary-panel">
            <h2>Order Summary</h2>
            <div class="summary-row"><span>Show</span><strong id="sumShow">-</strong></div>
            <div class="summary-row"><span>Date</span><strong id="sumDate">-</strong></div>
            <div class="summary-row"><span>Time</span><strong id="sumTime">-</strong></div>
            <div class="summary-row"><span>Venue</span><strong id="sumVenue">-</strong></div>
            <div class="summary-row"><span>Seats</span><strong id="sumSeats">-</strong></div>
            <hr>
            <div class="summary-row"><span>Subtotal</span><strong id="sumSubtotal">INR 0</strong></div>
            <div class="summary-row"><span>Convenience Fee</span><strong id="sumFee">INR 0</strong></div>
            <div class="summary-row total"><span>Total</span><strong id="sumTotal">INR 0</strong></div>
            <small>By proceeding, you agree to Ticketvarse booking terms.</small>
        </aside>
    </section>
</main>

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

<script src="payment.js"></script>
</body>
</html>


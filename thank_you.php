<?php
include 'db_connect.php';

$donation_id = isset($_GET['donation_id']) ? (int)$_GET['donation_id'] : 0;
$error = '';

if ($donation_id > 0) {
    $stmt = $conn->prepare("SELECT * FROM donations WHERE id = ?");
    $stmt->bind_param("i", $donation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $impact_type = htmlspecialchars($row['impact_type'] ?: 'General Support');
        $amount = $row['amount'];
        $custom_amount = $row['custom_amount'];
        $donation_amount = ($custom_amount > 0) ? $custom_amount : $amount;
        $amount_type = htmlspecialchars($row['amount_type'] ?: 'One-time');
        $donation_id_display = $row['id'];
    } else {
        $error = "Donation not found.";
    }
    $stmt->close();
} else {
    $error = "Invalid donation ID.";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - EduDonate</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <header class="navbar">
        <div class="container navbar-inner">
            <a href="index.html" class="logo">
                <i class="fa-solid fa-graduation-cap"></i>
                EduDonate
            </a>
            <nav class="nav-links">
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="programs.html">Programs</a></li>
                </ul>
            </nav>
            <a href="donate.html" class="btn btn-primary donate-now-btn">Donate Again</a>
        </div>
    </header>

    <main>
        <section class="thank-you-section">
            <div class="container">
                <div class="thank-you-content">
                    <i class="fa-solid fa-check-circle"></i>
                    <h1>Thank You for Your Donation!</h1>
                    <p>Your generous contribution will make a real difference in the lives of children. We've sent a receipt to your email.</p>
                    <?php if ($error): ?>
                        <div class="error-message" style="color: red; text-align: center; margin: 20px 0;"><?php echo $error; ?></div>
                    <?php else: ?>
                        <div class="donation-summary">
                        <h3>Donation Details</h3>
                        <p><strong>Program:</strong> <span><?php echo $impact_type; ?></span></p>
                        <p><strong>Amount:</strong> ₹<?php echo number_format($donation_amount, 2); ?></p>
                        <p><strong>Type:</strong> <span><?php echo $amount_type; ?></span></p>
                        <p><strong>Donation ID:</strong> <span><?php echo $donation_id_display; ?></span></p>
                        </div>
                    <?php endif; ?>
                    <div class="thank-you-actions">
                        <a href="index.html" class="btn btn-primary">Return Home</a>
                        <a href="programs.html" class="btn btn-secondary">Learn More About Our Programs</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="footer">
        <div class="container footer-grid">
            <div class="footer-about">
                <a href="index.html" class="logo footer-logo">
                    <i class="fa-solid fa-graduation-cap"></i>
                    EduDonate
                </a>
                <p>Empowering children through education and technology. Every donation creates a brighter future.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-links">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="about.html">About Us</a></li>
                    <li><a href="programs.html">Our Programs</a></li>
                    <li><a href="#">Impact Stories</a></li>
                    <li><a href="#">Get Involved</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Programs</h4>
                <ul>
                    <li><a href="programs.html#adopt-student">Adopt a Student</a></li>
                    <li><a href="programs.html#sponsor-village">Sponsor a Village</a></li>
                    <li><a href="programs.html#digital-tools">Digital Learning Tools</a></li>
                    <li><a href="donate.html">General Donations</a></li>
                </ul>
            </div>
            <div class="footer-contact">
                <h4>Contact Us</h4>
                <ul>
                    <li><i class="fa-solid fa-location-dot"></i> 123 Education Street, Learning City</li>
                    <li><i class="fa-solid fa-phone"></i> +1 (555) 123-4567</li>
                    <li><i class="fa-solid fa-envelope"></i> hello@edudonate.org</li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© 2024 EduDonate. All rights reserved.</p>
            <div class="legal-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </footer>

    <script src="script.js"></script>
</body>
</html>

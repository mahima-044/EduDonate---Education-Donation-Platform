<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Donations | EduDonate</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .admin-container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        .admin-table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .admin-table th, .admin-table td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        .admin-table th { background-color: #f8f9fa; font-weight: bold; }
        .admin-table tr:hover { background-color: #f5f5f5; }
        .no-data { text-align: center; padding: 40px; color: #666; }
        .back-link { display: inline-block; margin-bottom: 20px; color: #007bff; text-decoration: none; }
        .back-link:hover { text-decoration: underline; }
    </style>
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
                    <li><a href="donate.html">Donate</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="admin-container">
        <a href="donate.html" class="back-link"><i class="fas fa-arrow-left"></i> Back to Donate</a>
        <h2>Admin Dashboard - Donations</h2>
        <p>View all recorded donations below.</p>

        <?php
        include 'db_connect.php';

        $sql = "SELECT * FROM donations ORDER BY created_at DESC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<table class='admin-table'>";
            echo "<thead><tr>";
            echo "<th>ID</th>";
            echo "<th>First Name</th>";
            echo "<th>Last Name</th>";
            echo "<th>Email</th>";
            echo "<th>Phone</th>";
            echo "<th>Impact Type</th>";
            echo "<th>Amount Type</th>";
            echo "<th>Amount (₹)</th>";
            echo "<th>Custom Amount (₹)</th>";
            echo "<th>Created At</th>";
            echo "</tr></thead>";
            echo "<tbody>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                echo "<td>" . htmlspecialchars($row['first_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['last_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                echo "<td>" . htmlspecialchars($row['phone']) . "</td>";
                echo "<td>" . htmlspecialchars(ucwords(str_replace('-', ' ', $row['impact_type']))) . "</td>";
                echo "<td>" . ucfirst($row['amount_type']) . "</td>";
                echo "<td>" . number_format($row['amount'], 0) . "</td>";
                echo "<td>" . ($row['custom_amount'] > 0 ? number_format($row['custom_amount'], 0) : '-') . "</td>";
                echo "<td>" . $row['created_at'] . "</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='no-data'><i class='fas fa-inbox' style='font-size: 48px; color: #ddd; margin-bottom: 10px;'></i><p>No donations recorded yet.</p></div>";
        }

        $conn->close();
        ?>
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
</body>
</html>

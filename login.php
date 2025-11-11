<?php
include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die("Please enter both email and password.");
    }

    // Find user by email in registrations table
    $stmt = $conn->prepare("SELECT * FROM registrations WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            echo "<script>alert('Login successful! Redirecting...'); window.location.href='Admin-portal/dashboard.html';</script>";
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='Admin-portal/school-login.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email. Please register.'); window.location.href='Admin-portal/register.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

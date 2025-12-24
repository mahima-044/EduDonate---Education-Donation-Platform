<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
        die("Please enter both email and password.");
    }

    // Find user by email in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            echo "<script>alert('Login successful! Redirecting...'); window.location.href='index.html';</script>";
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='signup.html';</script>";
        }
    } else {
        echo "<script>alert('No account found with this email. Please sign up.'); window.location.href='signup.html';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
include('../db_connect.php'); // Include the connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate fields
    if (empty($email) || empty($password)) {
        echo "Please fill all fields.";
        exit;
    }

    // Check if user exists
    $sql = "SELECT * FROM registrations WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password (hashed)
        if (password_verify($password, $user['password'])) {
            echo "<h2>Welcome, " . htmlspecialchars($user['org_name']) . "!</h2>";
            echo "<p>Login successful. Redirecting to your dashboard...</p>";
            header("refresh:2;url=dashboard.html");
        } else {
            echo "<p>Invalid password. Try again.</p>";
        }
    } else {
        echo "<p>No account found with this email.</p>";
    }

    $stmt->close();
}
$conn->close();
?>

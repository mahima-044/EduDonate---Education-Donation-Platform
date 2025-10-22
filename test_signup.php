<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

$name = 'Test User 2';
$email = 'test2@example.com';
$password = 'password123';

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (full_name, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $name, $email, $hashed_password);

if ($stmt->execute()) {
    echo "Signup successful!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

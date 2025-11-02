<?php
include 'db_connect.php';

// Test registration: Insert a test user
$organization_name = "Test NGO";
$email = "test@ngo.com";
$password = password_hash("testpass", PASSWORD_DEFAULT);

$sql = "INSERT INTO ngo_users (organization_name, email, password) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $organization_name, $email, $password);

if ($stmt->execute()) {
    echo "✅ Test registration successful: User inserted into ngo_users.\n";
} else {
    echo "❌ Test registration failed: " . $stmt->error . "\n";
}
$stmt->close();

// Test login: Check if user exists and password verifies
$sql = "SELECT * FROM ngo_users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $row = $result->fetch_assoc();
    if (password_verify("testpass", $row['password'])) {
        echo "✅ Test login successful: User found and password verified.\n";
    } else {
        echo "❌ Test login failed: Password verification failed.\n";
    }
} else {
    echo "❌ Test login failed: No user found with this email.\n";
}

$stmt->close();
$conn->close();
?>

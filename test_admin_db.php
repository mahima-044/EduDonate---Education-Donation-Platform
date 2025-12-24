<?php
include 'db_connect.php';

// Test registration: Insert a test user
$org_name = "Test NGO";
$email = "test@ngo.com";
$phone = "1234567890";
$address = "Test Address";
$reg_number = "TEST123";
$reg_certificate = "test_cert.pdf";
$password = password_hash("testpass", PASSWORD_DEFAULT);

$sql = "INSERT INTO fundraiser_login (org_name, email, phone, address, reg_number, reg_certificate, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $org_name, $email, $phone, $address, $reg_number, $reg_certificate, $password);

if ($stmt->execute()) {
    echo "✅ Test registration successful: User inserted into fundraiser_login.\n";
} else {
    echo "❌ Test registration failed: " . $stmt->error . "\n";
}
$stmt->close();

// Test login: Check if user exists and password verifies
$sql = "SELECT * FROM fundraiser_login WHERE email = ?";
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

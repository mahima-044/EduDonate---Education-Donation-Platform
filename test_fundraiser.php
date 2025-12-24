<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

// Test data for fundraiser registration
$orgName = 'Test Organization';
$email = 'testfundraiser@example.com';
$phone = '1234567890';
$address = 'Test Address';
$regNumber = 'REG123';
$password = 'password123';

// Simulate file upload (create a dummy file path)
$regCertificate = 'uploads/test_certificate.pdf';

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into fundraiser_login table
$stmt = $conn->prepare("INSERT INTO fundraiser_login (org_name, email, phone, address, reg_number, reg_certificate, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $orgName, $email, $phone, $address, $regNumber, $regCertificate, $hashed_password);

if ($stmt->execute()) {
    echo "Fundraiser registration test successful!<br>";
} else {
    echo "Error in registration: " . $stmt->error . "<br>";
}

// Now test login
echo "<br>Testing login...<br>";

// Query the user
$stmt2 = $conn->prepare("SELECT * FROM fundraiser_login WHERE email = ?");
$stmt2->bind_param("s", $email);
$stmt2->execute();
$result = $stmt2->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo "Login test successful! Welcome, " . htmlspecialchars($user['org_name']) . "<br>";
    } else {
        echo "Password verification failed.<br>";
    }
} else {
    echo "User not found.<br>";
}

$stmt->close();
$stmt2->close();
$conn->close();
?>

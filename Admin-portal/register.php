<?php
include('db_connect.php'); // database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form inputs
    $orgName = $_POST['orgName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $regNumber = $_POST['regNumber'];
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirmPassword'];

    // Password check
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // ---------------------------
    // 🟩 FILE UPLOAD SECTION (replace your old one with this)
    // ---------------------------
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = basename($_FILES["regCertificate"]["name"]);
    $file_tmp = $_FILES["regCertificate"]["tmp_name"];
    $file_error = $_FILES["regCertificate"]["error"];

    if ($file_error !== UPLOAD_ERR_OK) {
        die("Error uploading file. Error code: " . $file_error);
    }

    $target_file = $target_dir . time() . "_" . $file_name;

    // Validate file type
    $allowed = ['pdf', 'jpg', 'jpeg', 'png'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed)) {
        die("Invalid file type. Only PDF, JPG, JPEG, PNG allowed.");
    }

    // Move uploaded file
    if (!move_uploaded_file($file_tmp, $target_file)) {
        die("Failed to move uploaded file. Please check folder permissions.");
    }

    // ---------------------------
    // 🟩 DATABASE INSERTION SECTION (keep this part same)
    // ---------------------------
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO registrations (org_name, email, phone, address, reg_number, reg_certificate, password)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $orgName, $email, $phone, $address, $regNumber, $target_file, $hashed_password);

    if ($stmt->execute()) {
        echo "<h2>✅ Registration Successful!</h2>";
        echo "<p>Your organization <strong>$orgName</strong> has been registered successfully.</p>";
        echo "<a href='../Admin-portal/school-login.html'>Click here to Login</a>";
    } else {
        echo "❌ Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'db_connect.php';

// Create table if not exists
$sql = "CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50),
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    impact_type VARCHAR(50),
    amount_type VARCHAR(20),
    amount DECIMAL(10,2),
    custom_amount DECIMAL(10,2),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === FALSE) {
    echo "Error creating table: " . $conn->error;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Collect form data
    $first_name = trim($_POST['first-name'] ?? '');
    $last_name = trim($_POST['last-name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $impact = $_POST['impact'] ?? '';
    $amount_type = $_POST['amount-type'] ?? '';
    $amount = (float)($_POST['donation-amount'] ?? 0);  // Already in rupees
    $custom_amount = (float)($_POST['custom-amount'] ?? 0);  // Already in rupees

    // Compute final amount: use custom if provided, else preset
    $final_amount = $custom_amount > 0 ? $custom_amount : $amount;

    // Basic validation
    if (empty($first_name) || empty($email)) {
        echo "Please fill in all required fields.";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }
    if ($final_amount <= 0) {
        echo "Please select or enter a valid donation amount.";
        exit;
    }

    // Insert data into the database
    $stmt = $conn->prepare("INSERT INTO donations (first_name, last_name, email, phone, impact_type, amount_type, amount, custom_amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssdd", $first_name, $last_name, $email, $phone, $impact, $amount_type, $amount, $custom_amount);

    if ($stmt->execute()) {
        $donation_id = $conn->insert_id;
        header("Location: thank_you.php?donation_id=$donation_id");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

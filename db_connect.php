<?php
// Database connection configuration
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = ""; // default is empty in XAMPP
$dbname = "edudonate_db";

// Create connection without database first
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create database if not exists
$sql = "CREATE DATABASE IF NOT EXISTS $dbname";
if ($conn->query($sql) === TRUE) {
    // Select the database
    $conn->select_db($dbname);
} else {
    die("Error creating database: " . $conn->connect_error);
}

// Create users table if not exists
$table_sql = "CREATE TABLE IF NOT EXISTS users (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($table_sql) !== TRUE) {
    die("Error creating table: " . $conn->error);
}

// Check if the table has the old 'name' column and rename it to 'full_name'
$result = $conn->query("SHOW COLUMNS FROM users LIKE 'name'");
if ($result && $result->num_rows > 0) {
    $alter_sql = "ALTER TABLE users CHANGE name full_name VARCHAR(100) NOT NULL";
    $conn->query($alter_sql);
}

// Create registrations table if not exists
$reg_table_sql = "CREATE TABLE IF NOT EXISTS registrations (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    org_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone VARCHAR(20),
    address TEXT,
    reg_number VARCHAR(50),
    reg_certificate VARCHAR(255),
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($reg_table_sql) !== TRUE) {
    die("Error creating registrations table: " . $conn->error);
}

// Create donation_requests table if not exists
$req_table_sql = "CREATE TABLE IF NOT EXISTS donation_requests (
    id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    category VARCHAR(100) NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    beneficiaries INT,
    description TEXT,
    image_path VARCHAR(255),
    document_path VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($req_table_sql) !== TRUE) {
    die("Error creating donation_requests table: " . $conn->error);
}
?>

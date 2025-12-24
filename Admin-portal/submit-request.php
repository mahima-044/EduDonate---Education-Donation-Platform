<?php
include('../db_connect.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST['title'];
    $category = $_POST['category'];
    $amount = $_POST['amount'];
    $beneficiaries = $_POST['beneficiaries'];
    $description = $_POST['description'];

    // Handle file uploads
    $image_path = "";
    $document_path = "";

    // Upload images (if any)
    if (isset($_FILES['images']) && is_array($_FILES['images']['error']) && $_FILES['images']['error'][0] == 0) {
        $targetDir = "uploads/images/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['images']['name'][0]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['images']['tmp_name'][0], $targetFile)) {
            $image_path = $targetFile;
        }
    }

    // Upload documents (if any)
    if (isset($_FILES['documents']) && is_array($_FILES['documents']['error']) && $_FILES['documents']['error'][0] == 0) {
        $targetDir = "uploads/documents/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = time() . "_" . basename($_FILES['documents']['name'][0]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['documents']['tmp_name'][0], $targetFile)) {
            $document_path = $targetFile;
        }
    }

    // Insert into database
    $sql = "INSERT INTO donation_requests (title, category, amount, beneficiaries, description, image_path, document_path)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssdisss", $title, $category, $amount, $beneficiaries, $description, $image_path, $document_path);

    if ($stmt->execute()) {
        echo "<script>alert('Donation request created successfully!'); window.location.href='dashboard.html';</script>";
    } else {
        echo "<script>alert('Error: Could not save your request.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

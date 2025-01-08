<?php
include 'db.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $job_id = intval($_POST['job_id']);
    $full_name = $conn->real_escape_string($_POST['full_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $message = $conn->real_escape_string($_POST['message']);

    if (isset($_FILES['resume']) && $_FILES['resume']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $resume_name = basename($_FILES['resume']['name']);
        $resume_path = $upload_dir . uniqid() . '-' . $resume_name;

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        if (move_uploaded_file($_FILES['resume']['tmp_name'], $resume_path)) {
            $sql = "INSERT INTO job_applications (job_id, full_name, email, phone, message, resume_path)
                    VALUES ('$job_id', '$full_name', '$email', '$phone', '$message', '$resume_path')";

            if ($conn->query($sql) === TRUE) {
                echo "Your application has been submitted successfully!";
            } else {
                echo "Database error: " . $conn->error;
            }
        } else {
            echo "Failed to upload the resume.";
        }
    } else {
        echo "Resume upload failed. Please try again.";
    }
}

$conn->close();

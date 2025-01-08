<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $title = $_POST['job_title'];
    $category = $_POST['category'];
    $skills = $_POST['skills'];
    $description = $_POST['description'];
    $budget = $_POST['budget'];
    $deadline = $_POST['deadline'];

    $sql = "INSERT INTO jobs (user_id, title, category, skills, description, budget, deadline) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $user_id, $title, $category, $skills, $description, $budget, $deadline);

    if ($stmt->execute()) {
        echo "Job successfully listed!";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}

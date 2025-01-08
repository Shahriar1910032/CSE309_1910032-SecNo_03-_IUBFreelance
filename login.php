<?php
session_start();
$conn = new mysqli("localhost", "root", "", "iubfreelance");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$sql = "SELECT * FROM users WHERE email = ? AND role = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $role);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['email'];
        $_SESSION['role'] = $user['role']; 

        if ($user['role'] == 'buyer') {
            header("Location: buyer-dashboard.php"); 
        } else if ($user['role'] == 'seller') {
            header("Location: seller-dashboard.php"); 
        }
    } else {
        echo "Invalid password!";
    }
} else {
    echo "User not found or role mismatch!";
}

$stmt->close();
$conn->close();

<?php
$conn = new mysqli("localhost", "root", "", "iubfreelance");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$email = $_POST['username'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        echo "Login successful! Welcome, " . htmlspecialchars($user['fullname']);
    } else {
        echo "Invalid password. <a href='login.html'>Try again</a>";
    }
} else {
    echo "No user found with that email. <a href='signup.html'>Sign up</a>";
}

$stmt->close();
$conn->close();

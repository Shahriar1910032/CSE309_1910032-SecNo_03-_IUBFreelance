<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT fullname, email, bio, role FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found!";
    exit();
}

$stmt->close();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $bio = $_POST['bio'];

    if (empty($fullname) || empty($email)) {
        echo "Please fill in all required fields.";
    } else {
        $update_sql = "UPDATE users SET fullname = ?, email = ?, bio = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("sssi", $fullname, $email, $bio, $user_id);

        if ($update_stmt->execute()) {
            $_SESSION['profile_updated'] = true;
            header("Location: edit-profile.php?success=true");
            exit();
        } else {
            echo "Error updating profile.";
        }

        $update_stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .notification {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            text-align: center;
            display: none;
        }
    </style>
</head>

<body>

    <section class="dashboard">
        <h1>Edit Your Profile</h1>
        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            <div class="notification" id="successNotification">
                Profile updated successfully!
            </div>
        <?php endif; ?>

        <!-- Profile Edit Form -->
        <form action="edit-profile.php" method="POST">
            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" value="<?php echo htmlspecialchars($user['fullname']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="bio">Bio:</label>
            <textarea name="bio" id="bio" rows="4"><?php echo htmlspecialchars($user['bio']); ?></textarea>

            <button type="submit">Update Profile</button>
        </form>

    </section>

    <script>
        const successNotification = document.getElementById('successNotification');
        if (successNotification) {
            successNotification.style.display = 'block';
            setTimeout(function() {
                <?php if ($user['role'] == 'buyer') : ?>
                    window.location.href = 'buyer-dashboard.php';
                <?php elseif ($user['role'] == 'seller') : ?>
                    window.location.href = 'seller-dashboard.php';
                <?php endif; ?>
            }, 3000);
        }
    </script>
</body>
</html>
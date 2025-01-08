<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT fullname, email, bio, id FROM users WHERE id = ?";
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            max-width: 1200px;
            margin: 30px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .tabs {
            text-align: center;
            margin-bottom: 20px;
        }

        .tab-link {
            display: inline-block;
            padding: 12px 20px;
            margin: 0 5px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

        .tab-link:hover {
            background-color: #0056b3;
        }

        .tab-link.active {
            background-color: #0056b3;
        }

        .tab-content {
            display: none;
        }

        .profile-details,
        .job-item,
        .notifications-section {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .job-item {
            background-color: #eef2f7;
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .job-item h3 {
            font-size: 20px;
            color: #333;
        }

        .notifications-section {
            background-color: #eef2f7;
            padding: 20px;
            border-radius: 8px;
        }

        .notifications-section h2 {
            font-size: 20px;
            color: #333;
        }

        .message {
            background-color: #eef2f7;
            border-left: 4px solid #007bff;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .message p {
            margin: 0;
            color: #333;
        }

        .message .time {
            font-size: 12px;
            color: #999;
            text-align: right;
        }
    </style>
</head>

<body>

    <section class="dashboard">
        <div class="obj-width">
            <h1>Welcome to Your Seller Dashboard, <?php echo htmlspecialchars($user['fullname']); ?>!</h1>

            <!-- Tab Navigation -->
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'Profile')">Profile</button>
                <button class="tab-link" onclick="window.location.href='browse-jobs.php'">Browse Jobs</button>
                <button class="tab-link" onclick="openTab(event, 'AppliedJobs')">Applied Jobs</button>
                <button class="tab-link" onclick="openTab(event, 'Logout')">Logout</button>
            </div>

            <!-- Tab Content -->
            <div id="Profile" class="tab-content" style="display: block;">
                <div class="profile-details">
                    <h2>Profile Details</h2>
                    <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Bio:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
                    <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                    <a href="edit-profile.php" class="btn">Edit Profile</a>
                </div>
            </div>

            <div id="BrowseJobs" class="tab-content">
                <div class="profile-details">
                    <h2>Browse Jobs</h2>
                    <p>Explore available job listings and apply to the ones you are interested in.</p>
                </div>
            </div>

            <div id="AppliedJobs" class="tab-content">
                <div class="profile-details">
                    <h2>Applied Jobs</h2>
                    <p>See the jobs you've applied for and their status.</p>
                    <?php
                    include('db.php');

                    $sql = "SELECT id, job_id, full_name, email, phone, message, created_at, status FROM job_applications";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($application = $result->fetch_assoc()) {
                    ?>
                            <div class="job-item">
                                <p><strong>Application ID:</strong> <?php echo htmlspecialchars($application['id']); ?></p>
                                <p><strong>Applicant Name:</strong> <?php echo htmlspecialchars($application['full_name']); ?></p>
                                <p><strong>Email:</strong> <?php echo htmlspecialchars($application['email']); ?></p>
                                <p><strong>Phone:</strong> <?php echo htmlspecialchars($application['phone']); ?></p>
                                <p><strong>Message:</strong> <?php echo htmlspecialchars($application['message']); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($application['status']); ?></p>
                                <p class="time"><strong>Submitted On:</strong> <?php echo htmlspecialchars($application['created_at']); ?></p>
                            </div>
                    <?php
                        }
                    } else {
                        echo "<p>No applications found.</p>";
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
            <div id="Logout" class="tab-content">
                <p><a href="logout.php" class="btn">Logout</a></p>
            </div>
        </div>
    </section>

    <script>
        function openTab(evt, tabName) {
            let i, tabContent, tabLinks;
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].style.display = "none";
            }
            tabLinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].className = tabLinks[i].className.replace(" active", "");
            }
            document.getElementById(tabName).style.display = "block";
            evt.currentTarget.className += " active";
        }
    </script>

</body>

</html>
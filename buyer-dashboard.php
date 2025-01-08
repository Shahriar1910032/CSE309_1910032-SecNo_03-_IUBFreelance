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
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
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

        .obj-width {
            width: 100%;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .tabs {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }

        .tab-link {
            padding: 10px 20px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 6px;
            cursor: pointer;
        }

        .tab-link.active {
            background-color: #007bff;
            color: white;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .profile-details {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .profile-details p {
            font-size: 16px;
            color: #666;
            margin: 8px 0;
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

        .job-listings,
        .applications {
            margin-top: 20px;
        }

        .job-item {
            padding: 15px;
            background-color: #f0f0f0;
            margin-bottom: 15px;
            border-radius: 6px;
        }

        .job-item h3 {
            margin: 0;
            font-size: 18px;
        }

        .message .time {
            font-size: 12px;
            color: #999;
            text-align: right;
        }

        .status-update-form {
            display: flex;
            align-items: center;
            margin-top: 15px;
        }

        .status-select {
            padding: 8px;
            font-size: 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            margin-right: 10px;
            width: 150px;
        }

        .btn-update {
            padding: 8px 16px;
            font-size: 14px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-update:hover {
            background-color: #218838;
        }

        .resume-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .resume-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .resume-button:active {
            background-color: #003c82;
        }
    </style>
</head>

<body>

    <section class="dashboard">
        <div class="obj-width">
            <h1>Welcome to Your Buyer Dashboard, <?php echo htmlspecialchars($user['fullname']); ?>!</h1>

            <?php if (isset($_SESSION['status_update_message'])): ?>
                <p style="color: green; text-align: center;"><?php echo $_SESSION['status_update_message'];
                                                                unset($_SESSION['status_update_message']); ?></p>
            <?php endif; ?>

            <!-- Tab Navigation -->
            <div class="tabs">
                <button class="tab-link active" onclick="openTab(event, 'Profile')">Profile</button>
                <button class="tab-link" onclick="openTab(event, 'JobListings')">Job Listings</button>
                <button class="tab-link" onclick="openTab(event, 'GetOffer')">Get Offer</button>
                <button class="tab-link" onclick="openTab(event, 'Logout')">Logout</button>
            </div>

            <!-- Tab Content -->
            <div id="Profile" class="tab-content active">
                <h2>Profile Details</h2>
                <p><strong>Full Name:</strong> <?php echo htmlspecialchars($user['fullname']); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                <p><strong>Bio:</strong> <?php echo htmlspecialchars($user['bio']); ?></p>
                <p><strong>User ID:</strong> <?php echo htmlspecialchars($user['id']); ?></p>
                <a href="edit-profile.php" class="btn">Edit Profile</a>
            </div>

            <div id="JobListings" class="tab-content">
                <h2>List A Job</h2>
                <p>List A Job For sellers.</p>
                <div class="job-listings">
                    <a href="job-listing.html" class="btn">List A Job</a>
                </div>
            </div>

            <div id="GetOffer" class="tab-content">
                <h2>All Applications</h2>
                <div class="applications">
                    <?php
                    include('db.php');

                    $sql = "SELECT id, full_name, email, phone, message, created_at, status,resume_path FROM job_applications";
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
                                <p><strong>Status:</strong>
                                    <span id="status_display_<?php echo $application['id']; ?>" style="color: <?php echo $application['status'] == 'Approved' ? 'green' : ($application['status'] == 'Rejected' ? 'red' : 'orange'); ?>;">
                                        <?php echo htmlspecialchars($application['status']); ?>
                                    </span>
                                </p>
                                <p class="time"><strong>Submitted On:</strong> <?php echo htmlspecialchars($application['created_at']); ?></p>
                                <?php if (!empty($application['resume_path'])): ?>
                                    <p><strong>Resume:</strong>
                                        <a href="<?php echo htmlspecialchars($application['resume_path']); ?>" target="_blank" class="resume-button">
                                            <i class="fas fa-file-pdf"></i> View Resume
                                        </a>
                                    </p>
                                <?php else: ?>
                                    <p>No resume uploaded.</p>
                                <?php endif; ?>

                                <!-- Status Update Form -->
                                <form method="post" action="javascript:void(0);" class="status-update-form" onsubmit="updateStatus(event, <?php echo $application['id']; ?>)">
                                    <input type="hidden" name="application_id" value="<?php echo $application['id']; ?>">
                                    <label for="status_<?php echo $application['id']; ?>" style="font-size: 14px; font-weight: bold; margin-right: 10px;">Update Status:</label>
                                    <select id="status_<?php echo $application['id']; ?>" name="status" class="status-select">
                                        <option value="Pending" <?php echo $application['status'] == 'Pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="Approved" <?php echo $application['status'] == 'Approved' ? 'selected' : ''; ?>>Approved</option>
                                        <option value="Rejected" <?php echo $application['status'] == 'Rejected' ? 'selected' : ''; ?>>Rejected</option>
                                    </select>
                                    <button type="submit" class="btn-update">Update</button>
                                </form>
                                <p id="message_<?php echo $application['id']; ?>" style="color: green; text-align: center; display: none;"></p> <!-- Success Message -->
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
        function updateStatus(event, applicationId) {
            event.preventDefault();

            var status = document.getElementById("status_" + applicationId).value;
            var messageElement = document.getElementById("message_" + applicationId);
            var statusDisplay = document.getElementById("status_display_" + applicationId);

            var formData = new FormData();
            formData.append('application_id', applicationId);
            formData.append('status', status);

            fetch('update-status.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messageElement.style.color = 'green';
                        messageElement.textContent = data.message;
                        statusDisplay.textContent = status;
                        statusDisplay.style.color = status === 'Approved' ? 'green' : (status === 'Rejected' ? 'red' : 'orange');
                    } else {
                        messageElement.style.color = 'red';
                        messageElement.textContent = data.message;
                    }
                    messageElement.style.display = 'block';
                })
                .catch(error => {
                    messageElement.style.color = 'red';
                    messageElement.textContent = 'Error updating status.';
                    messageElement.style.display = 'block';
                });
        }

        function openTab(evt, tabName) {
            let i, tabContent, tabLinks;
            tabContent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabContent.length; i++) {
                tabContent[i].classList.remove("active");
            }
            tabLinks = document.getElementsByClassName("tab-link");
            for (i = 0; i < tabLinks.length; i++) {
                tabLinks[i].classList.remove("active");
            }
            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.add("active");
        }
    </script>
</body>
</html>
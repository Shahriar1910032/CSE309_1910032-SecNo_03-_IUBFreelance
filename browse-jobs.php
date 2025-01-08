<?php
include 'db.php';

$sql = "SELECT * FROM jobs ORDER BY created_at DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Jobs</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <header>
        <div id="navbar" class="obj-width">
            <a href="index.php"><img src="assets/logo.png" class="logo" alt="" /></a>
            <ul id="menu">
                <li><a href="index.php">Home</a></li>
                <li><a href="browse-jobs.php">Browse Jobs</a></li>
                <li><a href="job-listing.html">List Jobs</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="login.html">Login</a></li>
                <a href="signup.html">
                    <button id="w-btn">Join Now</button>
                </a>
            </ul>
            <i id="bar" class="bx bx-menu"></i>
        </div>
    </header>
    <section class="browse-jobs sec-sapce">
        <div class="obj-width">
            <h1>Browse Jobs</h1>
            <p>Explore the latest job listings and find the one that suits your skills and career goals.</p>
            <div class="jobs-container1">
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='job-card2'>";
                        echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
                        echo "<p>Category: " . htmlspecialchars($row['category']) . "</p>";
                        echo "<p>Skills: " . htmlspecialchars($row['skills']) . "</p>";
                        echo "<p>Budget: ৳" . htmlspecialchars($row['budget']) . "</p>";
                        echo "<p>Deadline: " . htmlspecialchars($row['deadline']) . "</p>";
                        echo "<p>user_id: " . htmlspecialchars($row['user_id']) . "</p>";
                        echo "<a href='apply.html?job_id=" . $row['id'] . "' class='g-btn'>Apply Now</a>";
                        echo "</div>";
                    }
                } else {
                    echo "<p>No jobs available at the moment.</p>";
                }

                $conn->close();
                ?>
            </div>
        </div>
    </section>
    <footer class="footer">
        <div class="obj-width">
            <div class="top">
                <div>
                    <img src="assets/logo.png" class="logo" alt="" />
                    <p>Search your desiered jobs.</p>
                </div>
                <div>
                    <a href="https://www.youtube.com/"><i class="bx bxl-youtube"></i></a>
                    <a href="https://github.com/dashboard"><i class="bx bxl-github"></i></a>
                    <a href="https://github.com/dashboard"><i class="bx bxl-instagram-alt"></i></a>
                    <a href="https://github.com/dashboard"><i class="bx bxl-twitter"></i></a>
                </div>
            </div>

            <div class="bottom">
                <div>
                    <h3>Main Menu</h3>
                    <a href="index.php">Home</a>
                    <a href="browse-jobs.php">Browse Job</a>
                    <a href="contact.html">Contact</a>
                    <a href="signup.html">Join Now</a>
                </div>
                <div>
                    <h3>Community</h3>
                    <a href="https://www.youtube.com/">Youtube</a>
                    <a href="https://github.com/dashboard">GitHub</a>
                    <a href="https://Twitter.com/dashboard">Twitter</a>
                    <a href="#">Project</a>
                </div>
                <div>
                    <h3>Help</h3>
                    <a href="about.html">About Us</a>
                    <a href="contact.html">Contact Us</a>
                </div>
                <div>
                    <h3>Policy</h3>
                    <a href="terms.html">Terms of Services</a>
                    <a href="privacy.html">Privacy</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
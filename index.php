<?php
include 'db.php';

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
$sql = "SELECT title, category, skills, budget, deadline, user_id FROM jobs";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Freelancing Website | Coding Shahriar</title>
  <link rel="stylesheet" href="style.css" />
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
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

  <!---------- Hero Section ------------->
  <section class="hero">
    <div class="hero-box obj-width">
      <div class="h-left">
        <h1>Find the perfect freelance services for your business.</h1>
        <p>
          Work with talented people at the most affordable price to get the
          most out of your time and cost.
        </p>
        <div class="search">
          <input type="text" placeholder="Search Your Job her..." />
          <a id="g-btn" href="browse-jobs.php">Search</a>
        </div>
      </div>
      <div class="h-right">
        <img src="assets/hero1.PNG" alt="" />
      </div>
    </div>
  </section>

  <!---------- Features Section ------------->
  <section class="features sec-sapce obj-width">
    <h2>Need something done?</h2>
    <p>Most viewed and all time top selling services</p>
    <div class="fe-box">
      <div>
        <img src="assets/fe 1.png" alt="" />
        <h3>Post a job</h3>
        <p>
          It's free and easy to post a job. Simply fill in a title,
          descripation.
        </p>
      </div>
      <div>
        <img src="assets/fe 2.png" alt="" />
        <h3>Choose freelancers</h3>
        <p>
          It's free and easy to post a job. Simply fill in a title,
          descripation.
        </p>
      </div>
      <div>
        <img src="assets/fe 3.png" alt="" />
        <h3>Pay Safely</h3>
        <p>
          It's free and easy to post a job. Simply fill in a title,
          descripation.
        </p>
      </div>
      <div>
        <img src="assets/fe 4.png" alt="" />
        <h3>We're here to help</h3>
        <p>
          It's free and easy to post a job. Simply fill in a title,
          descripation.
        </p>
      </div>
    </div>
  </section>

  <!---------- Job Listing Section ------------->
  <section class="jobs sec-sapce obj-width">
    <h2>Browse Job</h2>
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
          echo "<a href='apply.html' class='g-btn'>Apply Now</a>";
          echo "</div>";
        }
      } else {
        echo "<p>No jobs available at the moment.</p>";
      }

      $conn->close();
      ?>
    </div>
  </section>

  <!---------- Brand Section ------------->
  <section class="trust sec-sapce obj-width">
    <h2>Trusted by the world's best</h2>
    <p>Most viewed and all time top selling services</p>

    <div class="t-box">
      <img src="assets/t1.png" alt="" />
      <img src="assets/t2.png" alt="" />
      <img src="assets/t3.png" alt="" />
      <img src="assets/t4.png" alt="" />
      <img src="assets/t5.png" alt="" />
    </div>
  </section>

  <!---------- Team Section ------------->
  <section class="team sec-sapce obj-width">
    <h2>Highest Rated Freelancer</h2>
    <p>Most viewed and all time top selling services</p>

    <div class="team-container">
      <div class="f1-box">
        <img src="assets/fl-1.png" alt="" />
        <h3>Shahriar Hosen</h3>
        <div class="skill">
          <span id="key">HTML</span>
          <span id="key">CSS</span>
          <span id="key">JS</span>
        </div>
      </div>
      <div class="f1-box">
        <img src="assets/fl-2.png" alt="" />
        <h3>Samarah</h3>
        <div class="skill">
          <span id="key">HTML</span>
          <span id="key">CSS</span>
          <span id="key">JS</span>
        </div>
      </div>
      <div class="f1-box">
        <img src="assets/fl-3.png" alt="" />
        <h3>Darrek Steward</h3>
        <div class="skill">
          <span id="key">HTML</span>
          <span id="key">CSS</span>
          <span id="key">JS</span>
        </div>
      </div>
      <div class="f1-box">
        <img src="assets/fl-4.png" alt="" />
        <h3>Marzia</h3>
        <div class="skill">
          <span id="key">HTML</span>
          <span id="key">CSS</span>
          <span id="key">JS</span>
        </div>
      </div>
    </div>
    <div class="location-container">
      <h2>Our Location</h2>
      <p>Visit us at our office location below or get directions to reach us:</p>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3650.0868839674!2d90.424968574794!3d23.815509286274725!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c64be6744a57%3A0xeacead51ebe2bf60!2sIndependent%20University%2C%20Bangladesh!5e0!3m2!1sen!2sbd!4v1731244125593!5m2!1sen!2sbd"
        class="large-map" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
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
  <script src="script.js"></script>
  <script src="main.js"></script>
</body>
</html>
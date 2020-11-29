<?php
session_start();

require_once "../Database_OOP/connect_Team10AM_db.php";
//Connect to the ilinkserver database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();

if ($_SESSION["logged_in"] != true) {
    echo("<h1>Access denied!</h1>");
    exit();
}
?>

<html>
<head>
    <title>UTEP Miners Account</title>
    <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../style_sheets/student_style.css">
</head>

<body>

<!-- -------- TITLE BAR WITH UTEP LOGO -------- -->
<div class="big-wrapper">
    <img src="../pictures/box_logo_orange.PNG">

    <div class="title-bar">
        <h1>Computer Science Advising</h1>
    </div>
</div>

<!-- -------- NAVIGATION BAR -------- -->

<div class="top-nav">
    <a href="../sign_out.php">Sign out</a>
    <a href="student_schedule.php">Schedule</a>
    <a href="student_documents.php">Documents</a>
    <a href="student_profile.php">Profile</a>
    <a class="active" href="student.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <p>Welcome <?php echo("{$_SESSION['users_name']}");?>,<br></p>

        <a href="appt_message.php">
            <img class="first-div" alt="schedule_appt" src="../pictures/get_advised_img.png">
        </a>

        <a href="student_profile.php">
            <img class="second-div" alt="schedule_appt" src="../pictures/profile_details_img.png">
        </a>

        <a href="student_schedule.php">
            <img class="third-div" alt="schedule_appt" src="../pictures/availability_image.png">
        </a>


</div>


<!-- ---------- FOOTER ---------- -->
<footer>
    <div class="container">
        <div class="footer-wrapper">
            <h2>The University of Texas at El Paso</h2>
            <p>The Computer Science Department</p>
        </div>
    </div>
</footer>

</body>

</html>

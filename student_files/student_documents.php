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
    <a class="active" href="student_documents.php">Documents</a>
    <a href="student_profile.php">Profile</a>
    <a href="student.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <table id="advisingForm">
        <caption><b>ADVISING FORM</b></caption>
        <tr>
            <th>Subject</th>
            <th>Course No.</th>
            <th>CRN</th>
            <th>Course Title</th>
            <th>Times</th>
            <th>Bldg/Room</th>
        </tr>
        <tr>
            <td>CS</td>
            <td>4375</td>
            <td>25380</td>
            <td>Software Engineering: Design and Implementation</td>
            <td>MW 10:30 - 11:50 PM</td>
            <td>ONLINE</td>
        </tr>
        <tr>
            <td>CS</td>
            <td>5352</td>
            <td>27258</td>
            <td>Theory of Operating Systems</td>
            <td>TR 10:30 - 11:50 AM</td>
            <td>ONLINE</td>
        </tr>
        <tr>
            <td>CS</td>
            <td>5387</td>
            <td>21690</td>
            <td>Computer Security</td>
            <td>MW 4:30 - 5:50 PM</td>
            <td>ONLINE</td>
        </tr>
        <tr>
            <td>CS</td>
            <td>4311</td>
            <td>22286</td>
            <td>Software Integration and V&V</td>
            <td>MW 6:00 - 8:50 PM</td>
            <td>ONLINE</td>
        </tr>

    </table>
    <button class="btn btn1" style="float: right">VIEW FLOWCHART</button>

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

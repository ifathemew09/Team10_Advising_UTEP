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
    <a class="active" href="student_schedule.php">Schedule</a>
    <a href="student_documents.php">Documents</a>
    <a href="student_profile.php">Profile</a>
    <a href="student.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <p>Your advisor is [advisor]. The following times are available to schedule with your advisor. Please select the times you are available for advising. </p>
    <form action ="">
        <input type="checkbox" id="moct12" name="moct12" value="mon">
        <label for="vehicle1">Monday, October 12</label><br>

        <input type="checkbox" id="toct13" name="toct13" value="tues">
        <label for="vehicle1">Tuesday, October 13</label><br>

        <input type="checkbox" id="woct14" name="woct14" value="wed">
        <label for="vehicle1">Wednesday, October 14</label><br>

        <input type="checkbox" id="roct15" name="roct15" value="thur">
        <label for="vehicle1">Thursday, October 15</label><br>

        <input type="checkbox" id="foct16" name="foct16" value="fri">
        <label for="vehicle1">Friday, October 16</label><br>

        <input type="button" value="Request" class="btn btn1">

    </form>




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

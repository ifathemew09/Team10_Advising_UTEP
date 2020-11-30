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

$session_advisor_ID = $_SESSION['advisor-id'];
//Select current advisors list of students
$sql = "SELECT * FROM student WHERE ADVadvisor_ID = $session_advisor_ID";
$result = mysqli_query($conn,$sql);

_header();

while( $row = mysqli_fetch_array($result) ){
    //If student is scheduled and their column value is 1, then they do have an appointment with the advisor
    if( $row['Sis_scheduled'] == 1 ){ $isStudentScheduled = "Yes"; }
    else{ $isStudentScheduled = "No"; }

    //$row['column_name']
    echo "<tr><td>" . $row['Sfirst_name'] . "</td><td>" . $row['Smiddle_name'] . "</td><td>" . $row['Slast_name']
        . "</td><td>" . $row['Sstudent_ID'] . "</td><td>" . $isStudentScheduled . "</td><td> <button class='btn btn1'>Edit</button> </td><tr>";
}


_end_file();

function _header(){
    print<<<HERE
<html>
<head>
    <title>UTEP ADVISING</title>
    <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../style_sheets/advisor_style.css">
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
    <a href="advisor_schedule.php">Schedule</a>
    <a class="active" href="advisor_studentlist.php">Student List</a>
    <a href="advisor.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <table id="advisingForm">
        <caption><b>STUDENT LIST</b></caption>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Student ID</th>
            <th>Student Scheduled</th>
            <th>Advising Form</th>
        </tr>
HERE;

}

function _end_file(){
    print<<<HERE
    </table>


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
HERE;
}

?>
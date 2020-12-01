<?php
session_start();

require_once "../Database_OOP/connect_Team10AM_db.php";
//Connect to the ilinkserver database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();

if ($_SESSION["logged_in"] != true) {
    echo("<h1>Access denied!</h1>");
    exit();
}//END if

function _mainCode(){
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
    <a class="active" href="advisor_schedule.php">Schedule</a>
    <a href="advisor_studentlist.php">Student List</a>
    <a href="advisor.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <p>Your appointments are listed below: <br></p>
    <table id="advisingForm">
        <caption><b>SCHEDULED APPOINTMENTS</b></caption>
        <tr>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Last Name</th>
            <th>Student ID</th>
            <th>Meeting Time</th>
        </tr>
HERE;

}//end mainCode

function _endFile(){
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

}//end _endFile

_mainCode();

$session_advisorID = $_SESSION['advisor-id'];
//Select current advisors list of students
$sql = "SELECT * FROM approved_meetings WHERE ADVadvisor_ID = $session_advisorID";
$result = mysqli_query($conn,$sql);

/* LIST OF APPROVED STUDENTS */
while( $row = mysqli_fetch_array($result) ){
    $isApproved = "WAITING";
    //Store current student ID in the list of approved meetings
    $studentID = $row['Sstudent_ID'];
    //Command to search for student in table
    $studentSQL = "SELECT * FROM student WHERE Sstudent_ID = $studentID";
    //Find this ID in the table
    $studentResult = mysqli_query($conn,$studentSQL);
    //Store all row information in an array
    $studentRow = mysqli_fetch_array($studentResult);

    //$row['column_name']
    echo "<tr><td>" . $studentRow['Sfirst_name'] . "</td><td>" . $studentRow['Smiddle_name'] . "</td><td>" . $studentRow['Slast_name']
        . "</td><td>" . $row['Sstudent_ID'] . "</td><td>" . date("g:i a",strtotime($row['meeting_time'])) . "</td><tr>";

}//end while

_endFile();
?>
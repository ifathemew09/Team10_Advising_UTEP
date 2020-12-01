<?php
session_start();

error_reporting(E_ALL ^ E_WARNING);

require_once "../Database_OOP/connect_Team10AM_db.php";
//Connect to the ilinkserver database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();

if ($_SESSION["logged_in"] != true) {
    echo("<h1>Access denied! You are not allowed to view this page.</h1>");
    exit();
}

_beginFile();

//Select current advisors list of students
$sql = "SELECT * FROM approved_meetings";
$result = mysqli_query($conn,$sql);

/* LIST OF APPROVED STUDENTS */
while( $row = mysqli_fetch_array($result) ){
    $advisorID = $row['ADVadvisor_ID'];
    $studentID = $row['Sstudent_ID'];
    $adminID = $row['ADMadmin_ID'];

    //Get Advisors Name from admin table using their ID
    $advisorQuery = "SELECT ADVfirst_name, ADVlast_name FROM advisor WHERE ADVadvisor_ID = $advisorID";
    $advisorName = mysqli_fetch_array(mysqli_query($conn,$advisorQuery)); //[0] = FIRST NAME , [1] = LAST NAME

    //Get Students Name from student table using their ID
    $studentQuery = "SELECT Sfirst_name, Slast_name FROM student WHERE Sstudent_ID = $studentID";
    $studentName = mysqli_fetch_array(mysqli_query($conn,$studentQuery)); //[0] = FIRST NAME , [1] = LAST NAME

    //Get Admins name from admin table using their ID
    $adminQuery = "SELECT ADMfirst_name, ADMlast_name FROM admin WHERE ADMadmin_ID = $adminID";
    $adminName = mysqli_fetch_array(mysqli_query($conn,$adminQuery)); //[0] = FIRST NAME , [1] = LAST NAME

    if( $adminName[0] == NULL || $adminName[1] == NULL ){
        $approvedBy = "N/A";
    }
    else{
        $approvedBy = $adminName[0] . " " . $adminName[1];
    }
    echo "<tr><td>" . $advisorName[0] . " " . $advisorName[1] . "</td>"
        . "<td>" . $studentName[0] . " " . $studentName[1] . "</td>"
        . "<td>" . date("Y-m-d",strtotime($row['meeting_time'])) . "</td>"
        . "<td>" . date("g:i a",strtotime($row['meeting_time'])) . "</td>"
        . "<td>" . $approvedBy. "</td>" . "</td><tr>";

}//end while

_endOfFile();

function _beginFile(){
    print<<<HERE
<html>
<head>
    <title>UTEP Miners Account</title>
    <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../style_sheets/admin_style.css">
</head>

<body>

<!-- -------- TITLE BAR WITH UTEP LOGO -------- -->
<div class="big-wrapper">
    <img src="../pictures/box_logo_orange.PNG">

    <div class="title-bar">
        <h1>Computer Science Advising Administrator</h1>
    </div>
</div>

<!-- -------- NAVIGATION BAR -------- -->

<div class="top-nav">
    <a href="../sign_out.php">Sign out</a>
    <a href="admin_approvals.php">Waiting Approvals</a>
    <a class="active" href="admin_appts.php">Appointments</a>
    <a href="admin.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <table id="apptTable">
        <caption><b>APPROVED APPOINTMENTS</b></caption>
        <tr>
            <th>Advisor</th>
            <th>Student</th>
            <th colspan="2">Appointment</th>
            <th>Approved By:</th>
            
        </tr>
HERE;

}//end beginFile

function _endOfFile(){
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

}//end endOfFile

?>
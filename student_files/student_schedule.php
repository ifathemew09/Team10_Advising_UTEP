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

//Store ID of student
$id = $_SESSION['id'];

//Get advisor ID from student table
$studentAdvisor = "SELECT ADVadvisor_ID FROM student WHERE Sstudent_ID = $id";
$studentAdvisorID = mysqli_fetch_array(mysqli_query($conn,$studentAdvisor));

//Get advisor name from advisor table
$advisorQuery = "SELECT ADVfirst_name, ADVlast_name FROM advisor WHERE ADVadvisor_ID = $studentAdvisorID[0]";
$advisorName = mysqli_fetch_array(mysqli_query($conn,$advisorQuery)); //USE

/* ---------- IF STUDENT SUBMITS APPT REQUEST ----------*/
if( isset($_POST['req']) ){
    $datetimeAppt = $_POST['student-date'];
    $insertDate = date("Y-m-d H:i:s", strtotime($datetimeAppt));

    $insert_request = "INSERT INTO requested_meeting (ADVadvisor_ID,Sstudent_ID, meeting_time, time_of_request) VALUES($studentAdvisorID[0],$id,'$insertDate',NOW());";
    echo "Date Time: " . $insertDate . "<br>Student's Advisor ID: " . $studentAdvisorID[0];

    if( !mysqli_query($conn,$insert_request) ){
        $_SESSION['request-error'] = 0;
    } else{
        $_SESSION['request-error'] = 1;
    }
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
    <p>Your advisor is <b><?php echo($advisorName[0] . " " . $advisorName[1]);?></b>. Please request a date and time you are available for advising. </p>
    <form action ="" method="post">
        <input type="datetime-local" id="student-date" name="student-date" >

        <br>

        <input style="position: absolute" type="submit" value="Request" class="btn btn1" name="req">

    </form>
    <?php
    if( $_SESSION['request-error'] == 1){
        echo "<h4 class='error' style='color: green'><br><br><br>Request has been sent.</h4>";
    }
    ?>



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

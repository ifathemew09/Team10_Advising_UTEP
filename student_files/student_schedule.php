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
//Store cancellation error if any
$_SESSION['reject-error'] = 0;
$_SESSION['cancel-msg'] = 0;

//Get advisor ID from student table
$studentAdvisor = "SELECT ADVadvisor_ID FROM student WHERE Sstudent_ID = $id";
$studentAdvisorID = mysqli_fetch_array(mysqli_query($conn,$studentAdvisor));

//Get advisor name from advisor table
$advisorQuery = "SELECT ADVfirst_name, ADVlast_name FROM advisor WHERE ADVadvisor_ID = $studentAdvisorID[0]";
$advisorName = mysqli_fetch_array(mysqli_query($conn,$advisorQuery)); //USE

//Check if student is scheduled
$isScheduledSQL = "SELECT Sis_scheduled FROM student WHERE Sstudent_ID = $id";
$isScheduled = mysqli_fetch_array(mysqli_query($conn,$isScheduledSQL)); //USE

if(  $isScheduled[0] == 1){
    //Show them their appointment
    _showAppointmentInfo($conn, $id, $advisorName);
}
else if( $isScheduled[0] == 0 ){
    //Show them the form to request
    _showRequestForm($conn, $studentAdvisorID[0], $id, $advisorName);
}
else{
    print<<<HERE
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
    <p>Awaiting approval...</p>
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

/* --------------- Function that displays page that shows appointment information of student if approved --------------- */
function _showAppointmentInfo($db, $studentID, $advName){
    print<<<HERE
<html>
<head>
    <title>UTEP Miners Account</title>
    <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../style_sheets/student_style.css">
    
    <script>
        function del(elem){
            var id = elem.id;
            //window.location.href = "admin_approvals.php?id=elem.id";
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('cancelled', id);
            window.location.search = urlParams;
        }//end function
        
    </script>
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
    <p style="color: green"><b>Your appointment has been approved.</b></p>
    <table id="advisingForm">
        <caption><b>Appointment Details</b></caption>
        <tr>
            <th>Advisor</th>
            <th colspan="2">Meeting Time</th>
            <th>Cancel Appt.</th>
        </tr>
HERE;

    //Select meeting information
    $sql = "SELECT meeting_time FROM approved_meetings WHERE Sstudent_ID = $studentID";
    $result = mysqli_fetch_array(mysqli_query($db,$sql)); //USE

    /* TABLE OF APPOINTMENT DETAILS */
    echo "<tr><td>" . $advName[0] . " " . $advName[1]
        . "</td><td>" . date("Y-m-d",strtotime($result[0])) . "</td>"
        . "<td>" . date("g:i a",strtotime($result[0])) . "</td><td>"
        . "<button onclick='del(this)' class='btn btn1' id='$studentID' type='submit'>Cancel</button> </td></tr>";

    print<<<HERE
    </table>
    <br> 
HERE;

    /* Display error if system is unable to cancel appointment. */
    if( isset($_SESSION['reject-error'])){
        if( $_SESSION['reject-error'] == 1 ){
            echo "<h3 style='color: red'>There was a problem in cancelling your appointment. Contact your advisor</h3>";
        }
    }

    if( isset($_SESSION['cancel-msg'])){
        if( $_SESSION['cancel-msg'] == 1 ){
            echo "<h3 style='color: green'><b>Your appointment was cancelled.</b></h3>";
        }
    }

    print<<<HERE
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

    if( isset($_GET['cancelled']) ) {
        $idOfStudent = intval($_GET['cancelled']);
        ////////////////////////
        $deleteRequest = "DELETE FROM approved_meetings WHERE Sstudent_ID = $idOfStudent";
        $changeStatus = "UPDATE student SET Sis_scheduled = 0 WHERE Sstudent_ID = $idOfStudent";

        $resultDel = mysqli_query($db,$deleteRequest);
        $resultStu = mysqli_query($db, $changeStatus);
        ///////////////////////
        if( !$resultDel || !$resultStu){
            $_SESSION['reject-error'] = 1;
        }

        $_SESSION['cancel-msg'] = 1;
    }

}//end function

/* --------------- Function that displays form to request an appointment with their advisor --------------- */
function _showRequestForm($db, $advID, $stuID, $advName){
    /* IF STUDENT IS ALREADY SCHEDULED, SHOW THEM A TABLE OF THEIR INFORMATION */
    print<<<HERE
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
    <p>Your advisor is <b>
HERE;
    echo($advName[0] . " " . $advName[1]);
    print<<<HERE
    </b>. Please request a date and time you are available for advising. </p>
<form action="" method="post">
    <input type="datetime-local" id="student-date" name="student-date">

    <br>

    <input style="position: absolute" type="submit" value="Request" class="btn btn1" name="req">

</form>
<br>
HERE;

    if( isset($_SESSION['request-error']) ){
        if( $_SESSION['request-error'] == 1){
            echo "<h4 class='error' style='color: green'><br><br><br>Request has been sent.</h4>";
        }
    }

    print<<<HERE
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

    /* ---------- IF STUDENT SUBMITS APPT REQUEST ----------*/
    if( isset($_POST['req']) ){
        $datetimeAppt = $_POST['student-date'];
        $insertDate = date("Y-m-d H:i:s", strtotime($datetimeAppt));

        $insert_request = "INSERT INTO requested_meeting (ADVadvisor_ID,Sstudent_ID, meeting_time, time_of_request) VALUES($advID,$stuID,'$insertDate',NOW());";

        if( !mysqli_query($db,$insert_request) ){
            $_SESSION['request-error'] = 0;
        } else{
            $_SESSION['request-error'] = 1;
        }
    }

}//end request function


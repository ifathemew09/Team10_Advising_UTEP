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

//Variables
$_SESSION['approve-error'] = 0;
$_SESSION['reject-error'] = 0;

/* -------- IF ADMIN DECIDES TO APPROVE/REJECT THE APPOINTMENT REQUEST OF THE STUDENT -------- */
if( isset($_GET['Sid-approved']) ){
    $idOfStudent = intval($_GET['Sid-approved']);
    ////////////////////////
    $updateReqMeeting = "UPDATE requested_meeting SET admin_approval = 1 WHERE Sstudent_ID = $idOfStudent";
    $updateStudent = "UPDATE student SET Sis_scheduled = 1 WHERE Sstudent_ID = $idOfStudent";
    $resultReq  = mysqli_query($conn, $updateReqMeeting);
    $resultStat = mysqli_query($conn, $updateStudent);

    ////////////////////////
    if( !$resultReq || !$resultStat ){
        $_SESSION['approve-error'] = 1;
    }
}

if( isset($_GET['Sid-rejected']) ){
    $idOfStudent = intval($_GET['Sid-rejected']);
    ////////////////////////
    $deleteRequest = "DELETE FROM requested_meeting WHERE Sstudent_ID = $idOfStudent";
    $resultDel = mysqli_query($conn,$deleteRequest);
    ///////////////////////
    if( !$resultDel ){
        $_SESSION['reject-error'] = 1;
    }

}

/* --------------------------------------------------------------------------------------------- */

_startOfFile();

//Select current advisors list of students
$sql = "SELECT * FROM meetings_yet_approved";
$result = mysqli_query($conn,$sql);

$adminID = $_SESSION['admin-id'];

/* LIST OF APPROVED STUDENTS */
while( $row = mysqli_fetch_array($result) ){
    //Store advisorID and studentID in a variable
    $advisorID = $row['ADVadvisor_ID'];
    $studentID = $row['Sstudent_ID'];

    //Get Advisors Name from admin table using their ID
    $advisorQuery = "SELECT ADVfirst_name, ADVmiddle_name, ADVlast_name, ADVadvisor_ID FROM advisor WHERE ADVadvisor_ID = $advisorID";
    $advisorName = mysqli_fetch_array(mysqli_query($conn,$advisorQuery)); //[0] = FIRST NAME , [1] = LAST NAME

    //Get Students Name from student table using their ID
    $studentQuery = "SELECT Sfirst_name, Smiddle_name, Slast_name, Sstudent_ID FROM student WHERE Sstudent_ID = $studentID";
    $studentName = mysqli_fetch_array(mysqli_query($conn,$studentQuery)); //[0] = FIRST NAME , [1] = LAST NAME

    echo "<tr><td>" . $studentName[0] . " " . $studentName[1] . " " . $studentName[2] . "</td>"
        . "<td>" . $advisorName[0] . " " . $advisorName[1] . " " . $advisorName[2] . "</td>"
        . "<td>" . date("Y-m-d",strtotime($row['meeting_time'])) . "</td>"
        . "<td>" . date("g:i a",strtotime($row['meeting_time'])) . "</td>"
        . "<td> <button onclick='addurl(this)' class='btn btn1' id='$studentName[3]' type='submit'>Approve</button> <button onclick='rejecturl(this)' class='btn btn1' id='$studentName[3]' type='submit'>Reject</button> </td><tr>";

}//end while

_endOfFile();

function _startOfFile(){
    print<<<HERE
<html>
<head>
    <title>UTEP Miners Account</title>
    <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../style_sheets/admin_style.css">
    <script>
        function addurl(elem){
            var id = elem.id;
            //window.location.href = "admin_approvals.php?id=elem.id";
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('Sid-approved', id);
            window.location.search = urlParams;
        }//end function
        
        function rejecturl(elem){
            var id = elem.id;
            //window.location.href = "admin_approvals.php?id=elem.id";
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('Sid-rejected', id);
            window.location.search = urlParams;
        }//end function
        
    </script>
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
    <a class="active" href="admin_approvals.php">Waiting Approvals</a>
    <a href="admin_appts.php">Appointments</a>
    <a href="admin.php">Home</a>
</div>

<!-- ---------- MAIN BODY CONTAINER OF PAGE ---------- -->
<div class="main-container">
    <table id="apptTable">
        <caption><b>NEEDS ATTENTION</b></caption>
        <tr>
            <th>Student</th>
            <th>Advisor</th>
            <th colspan="2">Meeting Time</th>
            <th colspan="2">Approve/Reject</th>
        </tr>
HERE;

}//end function

function _endOfFile(){
    print<<<HERE
    </table>
HERE;
    if( $_SESSION['approve-error'] == 1 ){
        echo "<h3 style='color: red'>There was a problem in accepting the students appointment request</h3>";
    }
    if( $_SESSION['reject-error'] == 1 ){
        echo "<h3 style='color: red'>There was a problem in rejecting the students appointment request.</h3>";
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

}//end function

?>

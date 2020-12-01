<?php
session_start();

require_once "../Database_OOP/connect_Team10AM_db.php";
//Connect to the ilinkserver database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();

if ($_SESSION["logged_in"] != true) {
    echo("<h1>Access denied!</h1>");
    exit();
} else{
    $studentID = $_SESSION['id'];
    //Search for student ID in student table
    $studentSQL = "SELECT * FROM student WHERE Sstudent_ID LIKE $studentID";
    //SELECT the UNIQUE username found in the database
    $studentResult = mysqli_query($conn, $studentSQL);
    //FETCH the array by association
    $studentRow = mysqli_fetch_array($studentResult,MYSQLI_ASSOC);
    //COUNT NUM OF ROWS/results found in the query for if statement
    $studentCount = mysqli_num_rows($studentResult);

if ($studentCount == 1 ) {
    $studentFirst = $studentRow['Sfirst_name'];
    $studentMid   = $studentRow['Smiddle_name'];
    $studentLast  = $studentRow['Slast_name'];
    $studentEmail = $studentRow['Semail'];
    $studentClassification = $studentRow['Sclassification'];
}


}


?>
<html lang="en">
<head>
    <title>UTEP Miners Account</title>
    <meta http-equiv="X-UA-Compatible" content="" >
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="../style_sheets/student_style.css">
</head>

<body>
<!-- -------- TITLE BAR WITH UTEP LOGO -------- -->
<div class="big-wrapper">
    <img src="../pictures/box_logo_orange.PNG" alt="UTEP Orange Logo">

    <div class="title-bar">
        <h1>Computer Science Advising</h1>
    </div>
</div>

<!-- -------- NAVIGATION BAR -------- -->

<div class="top-nav">
    <a href="../sign_out.php">Sign out</a>
    <a href="student_schedule.php">Schedule</a>
    <a href="student_documents.php">Documents</a>
    <a class="active" href="student_profile.php">Profile</a>
    <a href="student.php">Home</a>
</div>

<!-- ---------- PROFILE DIVIDER ----------- -->
<div class="main-container">
    <section class="container-middle">
        <div class="left-half">
            <article>
                <h2>STUDENT INFORMATION</h2>
                <p>
                    <b>First Name</b>
                    <br><?php echo $studentFirst;?>
                </p>
                <p>
                    <b>Middle Name</b>
                    <br><?php echo $studentMid;?>
                </p>
                <p>
                    <b>Last Name</b>
                    <br><?php echo $studentLast;?>
                </p>
                <p>
                    <b>UTEP ID</b>
                    <br><?php echo $studentID;?>
                </p>
                <p>
                    <b>E-Mail</b>
                    <br><?php echo $studentEmail;?>
                </p>
                <p>
                    <b>Classification</b>
                    <br><?php echo $studentClassification;?>
                </p>

            </article>
        </div>
        <div class="right-half">
            <article>
                <img src="../pictures/profile_icon.png" alt="Profile Icon" />
                <p>Advising documents can be accessed below.</p>

                <button class="btn btn1" onclick="window.location.href='student_documents.php';">ADVISING FORM</button>
                <button class="btn btn1">DEGREE FLOWCHART</button>
            </article>
        </div>
    </section>
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
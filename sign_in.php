<?php
session_start();

require_once "Database_OOP/connect_Team10AM_db.php";
//Connect to the ilinkserver database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();
$_SESSION['logged_in'] = false;
$_SESSION['users_name'] = "";
$_SESSION['error'] = 0;
$_SESSION['user-nonexistent'] = 0;

if ( !empty($_POST) ){
    if( isset($_POST['submit']) ){
        //Store Clients credentials and prevent SQL Injections
        $input_email    = mysqli_real_escape_string($conn, $_POST['email']);
        $input_password = mysqli_real_escape_string($conn, $_POST['pswd']);

        //SQL Commands to get information from database
        $studentSQL = "SELECT * FROM student WHERE Semail LIKE '$input_email'";
        $advisorSQL = "SELECT * FROM advisor WHERE ADVemail_address LIKE '$input_email'";
        //$adminSQL   = "SELECT * FROM admin WHERE Aemail_address LIKE '$input_email'";

        //SELECT the UNIQUE username found in the database
        $studentResult = mysqli_query($conn, $studentSQL);
        $advisorResult = mysqli_query($conn, $advisorSQL);
        //$adminResult = mysqli_query($conn, $adminSQL);

        //FETCH the array by association
        $studentRow = mysqli_fetch_array($studentResult,MYSQLI_ASSOC);
        $advisorRow = mysqli_fetch_array($advisorResult,MYSQLI_ASSOC);
        //$adminRow = mysqli_fetch_array($adminResult,MYSQLI_ASSOC);

        //COUNT NUM OF ROWS/results found in the query for if statement
        $studentCount = mysqli_num_rows($studentResult);
        $advisorCount = mysqli_num_rows($advisorResult);
        //$adminCount = mysqli_num_rows($adminResult);

        // LOGIN BASED ON USERS ACCESS TYPE
        if ($studentCount == 1 ) {
            $hashed_pswd = $studentRow['Spassword'];
            if( password_verify($input_password, $hashed_pswd) ){
                $_SESSION['users_name'] = $studentRow['Sfirst_name'];
                $_SESSION['logged_in'] = true;
                $_SESSION['status'] = "student";
                $_SESSION['id'] = $studentRow['Sstudent_ID'];
                //Student was successful in logging in
                header("Location: student_files/student.php");
            }
            else{
                $_SESSION['error'] = 1;
            }
        }
        elseif ($advisorCount == 1) {
            $hashed_pswd = $advisorRow['ADVpassword'];
            if( password_verify($input_password, $advisorRow['ADVpassword']) ){
                $_SESSION['users_name'] = $advisorRow['ADVfirst_name'];
                $_SESSION['logged_in'] = true;
                $_SESSION['status'] = "advisor";
                $_SESSION['advisor-id'] = $advisorRow['ADVadvisor_ID'];
                //Admin was successful in logging in
                header("Location: advisor_files/advisor.php");
            }
            else{
                $_SESSION['error'] = 1;
            }
        }
        /*
        elseif ($searchAdmin == 1) {
            if( password_verify($input_password, $adminRow['ADMpassword']) ){
                $_SESSION["user"] = $input_email;
                $_SESSION["logged_in"] = true;
                $_SESSION["status"] = "admin";
                //echo "Coordinator Found";
                header("Location: admin.php");
            }
            else{
                $_SESSION['error'] = 1;
            }
        } */
        else {
            $_SESSION['user-nonexistent'] = 1;
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" type="text/css" href="style_sheets/mainstyle.css">

    </head>

    <!--
    <div class="loginLogo"> -->


    <div>
        <img src="pictures/utep_banner_transparent.png"alt="UTEP_Banner" class="center_img">
    </div>

    <div class="title-signin">
        <h1>UTEP Single Sign On</h1>
    </div>


    <div class="w3-container">
        <form action="" method="post">
            <input type="text" id="email" name="email" placeholder="Username (e.g., domain\name)" >
            <input type="password" id="pswd" name="pswd" placeholder="Password" >

            <div>
                <button class="sub-btn sub-btn-medium" type="submit" name="submit">Log in</button>
            </div>

                <?php
                if( $_SESSION['error'] == 1){
                    echo "<h3 class='error' style='color: red'>Incorrect username/password</h3>";
                }
                if( $_SESSION['user-nonexistent'] == 1){
                    echo "<h3 class='error' style='color: red'>User does not exist</h3>";
                }
                ?>
        </form>

    </div>



</html>
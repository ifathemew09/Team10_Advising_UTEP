<?php
session_start();

require_once "Database_OOP/connect_Team10AM_db.php";
//Connect to the ilinkserver database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();
$_SESSION['logged_in'] = false;
$_SESSION['users_name'] = "";

if ( !empty($_POST) ){
    if( isset($_POST['submit']) ){
        //Store Clients credentials and prevent SQL Injections
        $input_email = isset($_POST['email']) ? $_POST['email'] : "";
        $input_password = isset($_POST['pswd']) ? $_POST['pswd'] : "";

        // $result = mysqli_query($conn, "SELECT * FROM user WHERE username='$input_username'");

        /* ----------- SEARCH QUERIES OF DIFFERENT USERS ----------- */
        //$searchAdmin = "SELECT COUNT(*) FROM admin WHERE ";
        $searchStudent = "SELECT COUNT(*) FROM student WHERE email_address LIKE '$input_email' ";
        $searchAdvisor = "SELECT COUNT(*) FROM advisor WHERE email_address LIKE '$input_email' ";
        $searchAdmin   = "SELECT COUNT(*) FROM admin WHERE email_address LIKE '$input_email' ";

        /* ----------- QUERY RESULTS ----------- */
        $studentResults = $conn->query($searchStudent)->fetch_array()[0];
        $advisorResults =$conn->query($searchAdvisor)->fetch_array()[0];
        $adminResults =$conn->query($searchAdmin)->fetch_array()[0];

        $studentRow = $studentResults->fetch_array(MYSQLI_ASSOC);
        $advisorRow = $advisorResults->fetch_array(MYSQLI_ASSOC);
        $adminRow = $adminResults->fetch_array(MYSQLI_ASSOC);

        // LOGIN BASED ON USERS ACCESS TYPE
        if ($studentResults > 0 ) {
            if( password_verify('$input_password', $studentRow['password']) ){
                $_SESSION['user'] = strval($input_email);
                $_SESSION['logged_in'] = true;
                $_SESSION["status"] = "student";
                //echo"User found";
                header("Location: student.php");
            }
            else{
                error_reporting(0);
                $errorMsg = "<div class='displayError'>*Password is incorrect. <br/></div>";
            }
        } elseif ($advisorResults > 0) {
            if( password_verify('$input_password', $advisorRow['password']) ){
                $_SESSION["user"] = $input_email;
                $_SESSION["logged_in"] = true;
                $_SESSION["status"] = "advisor";
                //echo "Admin Found";
                header("Location: advisor.php");
            }
            else{
                error_reporting(0);
                $errorMsg = "<div class='displayError'>*Password is incorrect. <br/></div>";
            }
        } elseif ($searchAdmin > 0) {
            if( password_verify('$input_password', $adminRow['password']) ){
                $_SESSION["user"] = $input_email;
                $_SESSION["logged_in"] = true;
                $_SESSION["status"] = "admin";
                //echo "Coordinator Found";
                header("Location: admin.php");
            }
            else{
                error_reporting(0);
                $errorMsg = "<div class='displayError'>*Password is incorrect. <br/></div>";
            }
        }else {
            error_reporting(0);
            $errorMsg = "<div class='displayError'>*User does not exist. Please try again. <br/></div>";
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
            <input type="text" id="email" name="email" placeholder="E-mail (e.g., domain\name" >
            <input type="password" id="pswd" name="pswd" placeholder="Password" >

            <div>
                <button class="sub-btn sub-btn-medium" type="submit" name="submit">Log in</button>
            </div>

        </form>

    </div>



</html>
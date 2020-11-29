<?php
session_start();
$_SESSION['error'] = 0;
require_once "Database_OOP/connect_Team10AM_db.php";
require_once "Database_OOP/clean_input.php";

//Connect to the cssrvlab01 database at UTEP
$databaseConnector = new DatabaseConnector();
$conn = $databaseConnector->connect();

//instantiate clean input
$cleanse = new Sanitizer();

function _insert_user($name){
    print <<<HERE
<div class="container">
    <p>The user '$name' was successfully inserted into the database. </p>
</div>
HERE;

}

function _insertion_error($command, $query_error){
    print <<<HERE
<div class="container">
    <p>ERROR: Was not able to execute '$command'--- '$query_error' . </p>
</div>
HERE;

}

/* Clients credentials */

//First Name
$input_firstName = $cleanse->cleanInput($_POST["fname"]);
//Middle Name
$input_middleName = $cleanse->cleanInput($_POST["mname"]);
//Last Name
$input_lastName  = $cleanse->cleanInput($_POST["lname"]);
//ID
$input_id = $cleanse->cleanInput($_POST["id"]);
//e-mail
$input_email  = $cleanse->cleanInput($_POST["email"]);
//password
$input_password  = $_POST["pswd"];
//Faculty/Staff or Student
$input_title  = $cleanse->cleanInput($_POST["user-title"]);
//Student Classification
$input_classification = $cleanse->cleanInput($_POST['s-classification']);

//Hashed password using PHP Salt --- Hashes using CRYPT_BLOWFISH algorithm
$hashed_password = password_hash($input_password, PASSWORD_BCRYPT);

$submitBtn = $_POST["submit"];

//Check if the button was submitted
if( isset($submitBtn) ){
    //Create variable that will hold sql commands
    $sql = "";
    //Attempt insertion into query based on title
    if( trim($input_title) == "admin"){
        echo "inside admin";
        $sql = "INSERT INTO admin (ADMadmin_ID, ADMfirst_name, ADMmiddle_name, ADMlast_name,ADMemail_address, ADMpassword) VALUES ($input_id, '$input_firstName','$input_middleName','$input_lastName','$input_email','$hashed_password');";
        if( !mysqli_query($conn,$sql) ){
            $_SESSION['error'] = 1;
        }

    }
    else if( trim($input_title) == "advisor"){
        echo "inside advisor<br>";
        $sql = "INSERT INTO advisor (ADVadvisor_ID, ADVfirst_name, ADVmiddle_name, ADVlast_name, ADVemail_address, ADVpassword) VALUES ($input_id, '$input_firstName','$input_middleName','$input_lastName','$input_email','$hashed_password');";
        if( !mysqli_query($conn,$sql) ){
            $_SESSION['error'] = 1;
        }
        echo "success";

    }
    else if( trim($input_title) == "student"){
        $sql = "INSERT INTO student (Sstudent_id,Sfirst_name,Smiddle_name,Slast_name,Semail,Spassword, Sclassification) VALUES ($input_id,'$input_firstName','$input_middleName','$input_lastName','$input_email','$hashed_password','$input_classification');";
        if( !mysqli_query($conn,$sql) ){
            $_SESSION['error'] = 1;
        }
    }

    else{ echo "Something went wrong"; }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>UTEP Miers Account</title>
    <meta http-equiv="X-UA-Compatible" content=""IE="Edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" type="text/css" href="style_sheets/newAcct_style.css">

</head>
<body>
    <div class="main-wrapper">
        <!-- HEADER BAR -->
        <div id="header">
            <a href="sign_in.php">
                <img src="pictures/banner_box.PNG" alt="Utep logo">
            </a>
        </div>
    </div>

<!-- FORM BOX -->
    <form action="" style="border:1px solid #ccc" method="post">
        <div class="container">
            <h1>REGISTER FACULTY/STUDENTS</h1>
            <p>Team 10 uses this form to insert users into the system in order to store hashed passwords! </p>
            <hr>

            <label for="fname"><b>First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="fname" id="fname" required>

            <label for="mname"><b>Middle Name</b></label>
            <input type="text" placeholder="Enter Middle Name" name="mname" id="mname">

            <label for="lname"><b>Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lname" id="lname" required>

            <label for="id"><b>ID</b></label>
            <input type="text" placeholder="Enter UTEP ID" name="id" id="id" required>

            <label for="email"><b>E-mail Address</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <label for="pswd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pswd" id="pswd" required>

            <hr>

            <!-- SELECT IF THE PERSON IS AN ADMIN, ADVISOR, OR A STUDENT-->
            <label for="user-title"><b>Select Title</b></label>
            <select class="w3-select w3-border" name="user-title" required>
                <option selected disabled>Title</option>
                <option value="admin">ADMINISTRATOR</option>
                <option value="advisor">ADVISOR</option>
                <option value="student">STUDENT</option>
            </select>

            <hr>

            <!-- IF A STUDENT, SELECT CLASSIFICATION -->
            <label for="s-classification"><b>Student Classification</b></label>
            <select class="w3-select w3-border" name="s-classification">
                <option selected disabled>Classification</option>
                <option value="freshman">FRESHMAN</option>
                <option value="sophomore">SOPHOMORE</option>
                <option value="junior">JUNIOR</option>
                <option value="senior">SENIOR</option>
            </select> <br/>

            <button type="submit" name="submit">Register User</button>
        </div>
        <?php if( $_SESSION['error'] == 1){ echo "<p style='color:red; float: right'>ERROR: Unable to insert into databse.</p>"; }?>
    </form>

</body>

</html>
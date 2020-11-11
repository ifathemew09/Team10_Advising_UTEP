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
            <p>Team 10 uses this form to insert users into the system in order to store hashed passwords.</p>
            <hr>

            <label for="fname"><b>First Name</b></label>
            <input type="text" placeholder="Enter First Name" name="fname" id="fname" required>

            <label for="mname"><b>Middle Name</b></label>
            <input type="text" placeholder="Enter Middle Name" name="mname" id="mname" required>

            <label for="lname"><b>Last Name</b></label>
            <input type="text" placeholder="Enter Last Name" name="lname" id="lname" required>

            <label for="email"><b>E-mail Address</b></label>
            <input type="text" placeholder="Enter Email" name="email" id="email" required>

            <label for="pswd"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="pswd" id="pswd" required>

            <!-- SELECT IF THE PERSON IS AN ADMIN, ADVISOR, OR A STUDENT-->
            <label for="user-title"><b>Select Title</b></label>
            <select class="w3-select w3-border" name="user-title">
                <option selected disabled>Title</option>
                <option value="admin">ADMINISTRATOR</option>
                <option value="advisor">ADVISOR</option>
                <option value="student">STUDENT</option>
            </select> <br/>

            <div class="clearfix">
                <button onclick="location.href='admin.php'" type="button" class="cancelbtn">Cancel</button>
            </div>

        </div>
    </form>

</body>

</html>
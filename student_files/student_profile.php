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
    <a href="sign_out.php">Sign out</a>
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
                    <br>first
                </p>
                <p>
                    <b>Middle Name</b>
                    <br>mid
                </p>
                <p>
                    <b>Last Name</b>
                    <br>last
                </p>
                <p>
                    <b>UTEP ID</b>
                    <br>id
                </p>
                <p>
                    <b>E-Mail</b>
                    <br>email
                </p>

            </article>
        </div>
        <div class="right-half">
            <article>
                <img src="../pictures/profile_icon.png" />
                <p>You can access your personal advising documents down below.</p>

                <button class="btn btn1" onclick="window.location.href='student_documents.php';">ADVISING FORM</button>
                <button class="btn btn1">DEGREE FLOWCHART</button>
                <button class="btn btn1">REQUEST EDIT</button>
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
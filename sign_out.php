<?php
// Initialize the session.
session_start();

// Unset all of the session variables.
unset($_SESSION['logged_in']);
unset($_SESSION['users_name']);
unset($_SESSION['error']);
unset($_SESSION['user-nonexistent']);
unset($_SESSION['status']);

// Finally, destroy the session.
session_destroy();

// Include URL for Login page to login again.
header("Location: sign_in.php");
exit;
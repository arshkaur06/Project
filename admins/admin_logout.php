<?php
session_start();
session_unset();     // Unset all session variables
session_destroy();   // Destroy the session

// Redirect to admin login page
header("Location: admin_login.php");
exit;
?>

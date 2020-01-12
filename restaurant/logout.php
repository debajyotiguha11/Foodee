<?php
/**
 *
 * logout.php used to Unset all of the session variables and Destroy the session of the user.
 *
 */
// Initialize the session
session_start();
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header("location: index.php");
exit;
?>

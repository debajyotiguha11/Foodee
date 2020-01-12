<?php
/**
 *
 * login.php authenticates the restaurant using this app.
 *
 */
include_once '../connection/connect.php';
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
if (isset($_POST['login'])) {
	session_start();
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$result = mysqli_query($conn, "SELECT * FROM restaurants WHERE email = '" . $email. "' and password = '" . md5($password). "'");
	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['user_id'] = $row['rid'];
		$_SESSION['user_name'] = $row['name'];
		$_SESSION['user_email'] = $row['email'];
		$_SESSION['user_restaurant'] = true;
		$_SESSION['error'] = "";
		header("Location: home.php");
		
		
	} else {
		$error=true;
		$_SESSION['error'] = "Incorrect Email or Password!!!";
		header("Location: index.php");
	}
}
?>

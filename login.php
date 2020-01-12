<?php
/**
 *
 * login.php authenticates the customers using this app.
 *
 */
include_once 'connection/connect.php';
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
if (isset($_POST['login'])) {
	session_start();
	$email = mysqli_real_escape_string($conn, $_POST['email']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$result = mysqli_query($conn, "SELECT * FROM customers WHERE email = '" . $email. "' and password = '" . md5($password). "'");
	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['user_id'] = $row['cid'];
		$_SESSION['user_name'] = $row['name'];
		$_SESSION['user_email'] = $row['email'];
		$_SESSION['preference'] = $row['preference'];
		header("Location: index.php");
		$_SESSION['error'] = "";
		
	} else {
		$error=true;
		$_SESSION['error'] = "Incorrect Email or Password!!!";
		header("Location: index.php");
	}
}
?>

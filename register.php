<?php
/**
 *
 * register.php is used to register new customers to this app.
 *
 */
include_once 'connection/connect.php';
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
$error = false;
if (isset($_POST["submit"])) {
    session_start();
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password =  $_POST['password'];
    $cpassword = $_POST['confirm_password'];	
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $preference = $_POST['preference'];
    
    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
	$error = true;
	$_SESSION['error'] = "Name must contain only alphabets and space";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
	$error = true;
	$_SESSION['error'] = "Please Enter Valid Email ID";
    }
    if(strlen($password) < 6) {
	$error = true;
	$_SESSION['error'] = "Password must be minimum of 6 characters";
    }
    if($password != $cpassword) {
	$error = true;
	$_SESSION['error'] = "Password and Confirm Password doesn't match";
    }
    
    $sql = "SELECT email FROM restaurants WHERE email = '$email' UNION SELECT email FROM customers WHERE email = '$email'";
    $result = mysqli_query($conn,$sql);
    if(mysqli_num_rows($result) > 0){
    	$error = true;
	$_SESSION['error'] = "Email already registered with us!";
    }
    
    if (!$error) {
    	$pass = md5(mysqli_real_escape_string($conn,$_POST['password']));
        $sql = "INSERT INTO customers(name, phone, email, password, gender, address, preference) VALUES('$name','$phone','$email','$pass','$gender','$address','$preference')";
	if(mysqli_query($conn, $sql)) {
			$_SESSION['error'] = "Successfully Registered!";
		} else {
		        $error = true;
			$_SESSION['error'] = "Error in registering...Please try again later!";
		}
	}
}
?>

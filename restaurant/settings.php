<?php
/**
 *
 * settings.php is used to change user attributes.
 *
 */
session_start();
include_once '../connection/connect.php';
include 'includes/header.php';
include 'includes/navigation.php';

if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_restaurant'])){
	header("Location: index.php");
}

if (isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant']) ) {
	$email = $_SESSION['user_email'];
	$result = mysqli_query($conn, "SELECT * FROM restaurants WHERE email = '" . $email. "'");
	if ($row = mysqli_fetch_array($result)) {
		$id = $row['rid'];
		$name = $row['name'];
		$phone = $row['phone'];
		$email = $row['email'];
		$address = $row['address'];
	}
}
$error = false;
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    
    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
	$error = true;
	$message = "Name must contain only alphabets and space";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
	$error = true;
	$message = "Please Enter Valid Email ID";
    }
    if(strlen($password) < 6) {
	$error = true;
	$message = "Password must be minimum of 6 characters";
    }
    
    if (!$error) {
    	$pass = md5(mysqli_real_escape_string($conn,$_POST['password']));
        $sql = "UPDATE restaurants SET name='$name', phone='$phone', email='$email', password='$pass', address='$address' WHERE rid='$id' AND email='$email'";
	if(mysqli_query($conn, $sql)) {
			$message = "Successfully Updated!";
			$_SESSION = array();
			session_destroy();
			header("location: index.php");
		} else {
		        $error = true;
			$message = "Error in registering...Please try again later!";
		}
	}
}
?>
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
<div class="col-sm-9">
   <h2>User Settings</h2>
        <p><input type="text" name="name" value="<?php echo $name ?>" required></p>
        <p><input type="tel" name="phone" value="<?php echo $phone ?>" pattern="[0-9]{4}[0-9]{3}[0-9]{3}" required></p>
	<p><input type="email" name="email" value="<?php echo $email ?>" disabled required></p>
	<p><input type="password" name="password" placeholder="New Password" required></p>
	<p><textarea name="address" required><?php echo $address ?></textarea></p>
            <input type="submit" name="submit" class="button" value="Update">
<div class="error"><?php if(isset($message)) echo $message; ?></div>
</div>
</form>
<?php
include 'includes/footer.php';

<?php
/**
 *
 * settings.php is used to change user attributes.
 *
 */
session_start();
include_once 'connection/connect.php';
include 'includes/header.php';
include 'includes/navigation.php';

if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
if(isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant'])) {
	header("Location: restaurant/settings.php");
}

if (isset($_SESSION['user_id']) && !isset($_SESSION['user_restaurant'])) {
	$email = $_SESSION['user_email'];
	$result = mysqli_query($conn, "SELECT * FROM customers WHERE email = '" . $email. "'");
	if ($row = mysqli_fetch_array($result)) {
		$id = $row['cid'];
		$name = $row['name'];
		$phone = $row['phone'];
		$email = $row['email'];
		$address = $row['address'];
		$gender = $row['gender'];
		$preference = $row['preference'];
	}
$error = false;
if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $gender = $_POST['gender'];
    $preference = $_POST['preference'];
    
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
        $sql = "UPDATE customers SET name='$name', phone='$phone', email='$email', password='$pass', gender='$gender', address='$address', preference='$preference' WHERE cid='$id' AND email='$email'";
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
	<p><input type="password" name="password" placeholder="New/Old Password" required></p>
	<p><textarea name="address" required><?php echo $address ?></textarea>
	<?php if($gender == '1'){ ?>
	<p>Male <input type="radio" name="gender" value="1" checked required> Female <input type="radio" name="gender" value="0" ></p>
	<?php } else {?>
	<p>Male <input type="radio" name="gender" value="1" required> Female <input type="radio" name="gender" value="0" checked></p>
	<?php } ?>
	<?php if($preference == '1'){ ?>
	<p>Veg <input type="radio" name="preference" value="1" checked required> Non-Veg <input type="radio" name="preference" value="0"> Both <input type="radio" name="preference" value="2"></p>
	<?php } else if($preference == '0') { ?>
	<p>Veg <input type="radio" name="preference" value="1" required> Non-Veg <input type="radio" name="preference" value="0" checked> Both <input type="radio" name="preference" value="2"></p>
	<?php } else { ?>
	<p>Veg <input type="radio" name="preference" value="1" required> Non-Veg <input type="radio" name="preference" value="0" > Both <input type="radio" name="preference" value="2" checked></p>
	<?php } ?>
            <input type="submit" name="submit" class="button" value="Update">
<div class="error"><?php if(isset($message)) echo $message; ?></div>
</div>
</form>

<?php  } include 'includes/footer.php';

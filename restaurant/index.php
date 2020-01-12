<?php
/**
 * index.php generates the initial page the restaurant sees when using this app.
 *
 * Invalid input(no values) is prevented by HTML required tags,
 * and by checking the input upon submission,
 * notifying the user the selection was invalid and providing the option to go back.
 *
 */
session_start();
if(isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant'])) {
	header("Location: home.php");
}

if(isset($_SESSION['user_id']) && !isset($_SESSION['user_restaurant'])) {
	header("Location: ../index.php");
}

include 'includes/header.php';
?>

<div id = "login" class="col-sm-6">
<form method="post" action="login.php">
        <img src="../images/logo.png" alt="Image of FoodShala" class="img-responsive center-block " width = "42%">
        <h4 class="text-center">Login to continue</h4>
        <center>
	<p><input type="email" name="email" placeholder="Email" required></p>
	<p><input type="password" name="password" placeholder="Password" required></p>
            <input type="submit" name="login" class="button" value="Login">
            <input type="button" class="button" value="Back" onClick="window.location.href='../'; ">
           </center>
</form>
 </div>

<div id = "food" class="col-sm-6">
<form method="post" action="register.php">
	<h4 class="text-center">Don't have an account ?</h4>
        <h4 class="text-center">Register to continue</h4>
        <center>
        <p><input type="text" name="name" placeholder="Name" required></p>
        <p><input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{4}[0-9]{3}[0-9]{3}" required></p>
	<p><input type="email" name="email" placeholder="Email" required></p>
	<p><input type="password" name="password" placeholder="Password" required></p>
	<p><input type="password" name="confirm_password" placeholder="Confirm Password" required></p>
	<p><textarea name="address" placeholder="Address" required></textarea></p>
            <input type="submit" name="submit" class="button" value="Register">
           </center>

</form>
</div>
<center><p><?php if(isset($_SESSION['error'])) echo $_SESSION['error']; ?></p></center>
<?php
include 'includes/footer.php';

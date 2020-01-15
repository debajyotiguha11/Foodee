<?php
/**
 * index.php generates the initial page the user sees when using this app.
 *
 * This page contains a form that has:
 *      dropdown selection of the available food items;
 *      number input field for the quantity
 *      button to add more items
 *      button to submit the order
 *
 * Invalid input(no values) is prevented by HTML required tags,
 * and by checking the input upon submission,
 * notifying the user the selection was invalid and providing the option to go back.
 *
 */
session_start();


include_once 'connection/connect.php';
include 'includes/header.php';

if(isset($_SESSION['preference'])){
if($_SESSION['preference'] == 1){
	$preference = $_SESSION['preference'];
	$sql = "SELECT r.name, m.mid, m.item, m.preference, m.description, m.price FROM menu m, restaurants r WHERE m.preference = '$preference' and m.rid = r.rid";
}
else if($_SESSION['preference']== 0){
	$preference = $_SESSION['preference'];
	$sql = "SELECT r.name, m.mid, m.item, m.preference, m.description, m.price FROM menu m, restaurants r WHERE m.preference = '$preference' and m.rid = r.rid";
}
else{
$sql = "SELECT r.name, m.mid, m.item, m.preference, m.description, m.price FROM menu m, restaurants r WHERE m.rid = r.rid";
}
}
else{
$sql = "SELECT r.name, m.mid, m.item, m.preference, m.description, m.price FROM menu m, restaurants r WHERE m.rid = r.rid";
}
?>


    <div class="col-sm-6">
    <h3>Menu</h3>
<?php
//iterate through the array of food objects and populate the menu with data from the objects
	echo '<div id="update">';
    	$result = mysqli_query($conn, $sql);
    	$r = mysqli_fetch_array($result);
    	if(!$r)
    		echo '<div class = "menuItem"> <h5 class="foodName"> Sorry!! No menu for today!! </h5></div>';
    	$result = mysqli_query($conn, $sql);
    	while($r = mysqli_fetch_array($result)) {
    			if($r['preference'] == 1) $p = '<img src="images/v.png">'; else $p = '<img src="images/nv.png">';
    			echo '<div class = "menuItem">
    			<h5 class="kitchenName">' . $r['name'] . '</h5>
              		<h5 class="foodName"> -> ' . $r['item'] . '</h5>
              		<p class="price"> | ₹' . $r['price'] . '</p>
              		<p class="price"> | ' . $p . '</p>
              		<p>' . $r['description'] . '</p>
              		</div>';
	}
	echo '</div>';
?>
   </div>
   
<div id="template" class="hide">
<?php if(!isset($_SESSION['user_restaurant'])) { ?>
    <div class="singleItem">
        <select class="item" name="items[]" required aria-required="true" id="quantity">
            <option value="" disabled selected>I want..</option>
            <?php

//create the food select dropdown
$result = mysqli_query($conn, $sql);
while($r = mysqli_fetch_array($result)) {

$quantity[$r['mid']] = $r['quantity'];
    echo '<option value="' . $r['mid'] . '">' . $r['item'] . '</option>';
}
?>

        </select>

       
        <input type="button" class="removeItem" value="x">



   </div>
   <?php } ?>
</div>

<form method="post" action="formhandler.php">
    <div id = "food" class="col-sm-6">
        <img src="images/logo.png" alt="Image of FoodShala" class="img-responsive center-block " width = "42%">
        <?php if(!isset($_SESSION['user_restaurant'])) { ?>
        <h4 class="text-center">What do you feel like eating today <?php if(isset($_SESSION['user_id'])) { $name = explode(" ",$_SESSION['user_name']); echo $name[0] ;} ?>?</h4> <?php } ?>
        <div class="form-group buttons">
        <?php if(!isset($_SESSION['user_restaurant'])) { ?>
            <input type="button" class="button" id="addItem" value="Add More">
            <input type="submit" class="button" value=" Place Order">
            <?php } if(isset($_SESSION['user_id'])) { ?>
            <input type="button" class="button" value="Dashboard" id="home" onClick="window.location.href='home.php'">
            <input type="button" class="button" value="Logout" id="home" onClick="window.location.href='logout.php'">
            <?php } else { ?>
            <input type="button" class="button" value="Login" id="login">
            <input type="button" class="button" value="Register" id="register">
            <?php } ?>
            <div class="error"><p><?php if(isset($_SESSION['error'])) echo $_SESSION['error']; ?></p></div>
        </div>
    </div>
</form>

<div id="loginform" class="hide">
<form method="post" action="login.php">
<div id = "food" class="col-sm-6">
        <img src="images/logo.png" alt="Image of FoodShala" class="img-responsive center-block " width = "42%">
        <h4 class="text-center">Login to continue</h4>
        <center>
	<p><input type="email" name="email" placeholder="Email" required></p>
	<p><input type="password" name="password" placeholder="Password" required></p>
            <input type="submit" name="login" class="button" value="Login">
            <input type="button" class="button" value="Back" onClick="location.reload(); ">
            <p><a href="restaurant/">Restaurant login here</a></p>
           </center>
        </div>
	</div>
</form>
</div>

<div id="registerform" class="hide">
<form method="post" action="register.php">
<div id = "food" class="col-sm-6">
        <img src="images/logo.png" alt="Image of FoodShala" class="img-responsive center-block " width = "42%">
        <h4 class="text-center">Register to continue</h4>
        <center>
        <p><input type="text" name="name" placeholder="Name" required></p>
        <p><input type="tel" name="phone" placeholder="Phone Number" pattern="[0-9]{4}[0-9]{3}[0-9]{3}" required></p>
	<p><input type="email" name="email" placeholder="Email" required></p>
	<p><input type="password" name="password" placeholder="Password" required></p>
	<p><input type="password" name="confirm_password" placeholder="Confirm Password" required></p>
	<p><textarea name="address" placeholder="Address" required></textarea>
	<p>Male <input type="radio" name="gender" value="1" required> Female <input type="radio" name="gender" value="0"></p>
	<p>Veg <input type="radio" name="preference" value="1" required> Non-Veg <input type="radio" name="preference" value="0"> Both <input type="radio" name="preference" value="2"></p>
            <input type="submit" name="submit" class="button" value="Register">
            <input type="button" class="button" value="Back" onClick="location.reload(); ">
            <p><a href="restaurant/">Restaurant register here</a></p>
           </center>
        </div>
	</div>
</form>
</div>

<?php
include 'includes/footer.php';

<?php
/**
 * formhandler.php checks if the user input was valid,
 * stores the user data into an array of Food objects, calls the calculation methods
 * and displays the order summary, subtotal(per item) price
 * (with detailed price breakdown the user can see if they click a button),
 * as well as the total price for the order.
 *
 */

include 'includes/header.php';
include_once 'connection/connect.php';
session_start();
$total = 0;
$c=0;


//check if the input is valid
if(!isset($_POST["items"])) {
    echo '<div class = "col-md-4 col-md-offset-4">
    <h5 class="errorMsg">Undecided what you want to order? We suggest you order one of each!</h5>
    <a href = "index.php">Take me back</a>';
} else {
    //loop through the $_POST array and create an array of Food objects the user ordered
    for ($i = 0; $i < count($_POST["items"]); $i++) {
	$c += 1;
        //store object parameters from the $_POST array into variables
        $type = $_POST["items"][$i];
        $mid[] = $type;
        
        $sql = "SELECT m.mid, r.name, m.item, m.description, m.price FROM menu m, restaurants r WHERE m.rid = r.rid and m.mid='$type'";
        $result = mysqli_query($conn, $sql);
    	$row[] = mysqli_fetch_array($result); 

    //create the order summary showing all the items and toppings ordered,
    //the subtotal for each item, and a cumulative total cost due.


        echo '  <div class = "orderSummary menuItem col-md-6 col-md-offset-3">          
                <h5 class="kitchenName">' . $row[$i][1] . ' -> ' . $row[$i][2] . '</h5>
                <p class="foodName cost">₹' . $row[$i][4] . ' </p>
                <button type="button" class="btn details"><i class="fa fa-chevron-down"></i></button>
                <div class = "priceDetails hide" >
                <p>Base price: (₹' . $row[$i][4] . ' /per item)</p>
                <p class="cost">₹' . $row[$i][4] . ' </p>';

	$tax = $row[$i][4]*9.6/100;
	$subtotal = $row[$i][4]*9.6/100+$row[$i][4];
        echo '
        <!-- <p>Subtotal before tax (' . $row[$i][1] . ' orders): </p>
        <p class="cost">₹' . $row[$i][1] . ' </p>-->
        
        <p>Tax (9.6%)</p>
        <p class="cost">₹' . $tax . ' </p>
        <hr>
        <p>Subtotal:</p>
        <p class="cost">₹' . $subtotal . ' </p>             
        </div>
        </div>';
    
        //calculate total
        $total += $subtotal;
    //end of foreach loop
    
 }

?>
<form method="post" action="order.php">
<input type="number" name="count" value="<?php echo $c?>" hidden>
<input type="text" name="mid" value="<?php print base64_encode(serialize($mid)) ?>" hidden>
<div id="finalPrice" class = "orderSummary menuItem col-md-6 col-md-offset-3">
    <h5 class="total">Total price:</h5>
    <?php echo '<p class="total cost">₹' . number_format($total, 2) . ' </p>'; if(isset($_SESSION['user_id'])) { ?>
    <input type="submit" name="order" value="order" class="btn btn-lite" onclick="return confirm('Are You Sure For Order?')">
    <input type="button" name="login" value="Back" class="btn btn-light" onclick="window.location.href='index.php'">
    <?php } else { ?>
    <input type="button" name="login" value="Login to continue" class="btn btn-light" onclick="window.location.href='index.php'">
    <?php } ?>
    </div>
</form>
<?php } include 'includes/footer.php';?>

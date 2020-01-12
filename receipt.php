<?php
/**
 * receipt.php displays the order summary, subtotal(per item) price
 * (with detailed price breakdown the user can see if they click a button),
 * as well as the total price for the order.
 *
 */

include 'includes/header.php';
include_once 'connection/connect.php';

session_start();
$total = 0;
$c=0;

include 'includes/navigation.php';

if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}

if(isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant'])) {
	header("Location: index.php");
}

//check if the input is valid
if(!isset($_GET["oid"])) {
    echo '<div class="col-sm-9">
      <h2>Receipt</h2><div class = "col-md-4 col-md-offset-2">
    <h5 class="errorMsg">Receipt not found!</h5>
    <a href = "home.php">Take me back</a></div>';
} else {    
	$id = $_GET["oid"];
        $sql = "SELECT o.oid, r.name, m.item, m.price, o.date, o.pay FROM restaurants r, orders o, menu m, customers c WHERE o.mid = m.mid and o.cid = c.cid and r.rid = m.rid and o.oid = '$id' and o.cid = '" . $_SESSION['user_id']. "'";
        $result = mysqli_query($conn, $sql);
    	$row = mysqli_fetch_array($result); 
	if($row[5] == 0)
		header("Location: home.php");
    //create the order summary showing all the items and toppings ordered,
    //the subtotal for each item, and a cumulative total cost due.


        echo ' <div class="col-sm-9">
      <h2>Receipt</h2>  <div class = "orderSummary menuItem col-md-6 col-md-offset-2">          
                <h5 class="kitchenName">' . $row[1] . ' -> ' . $row[2] . '</h5>
                <p class="foodName cost">₹' . $row[3] . ' </p>
                <button type="button" class="btn details"><i class="fa fa-chevron-down"></i></button>
                <div class = "priceDetails hide" >
                <p>Base price: (₹' . $row[3] . ' /per item)</p>
                <p class="cost">₹' . $row[3] . ' </p>';

	$tax = $row[3]*9.6/100;
	$subtotal = $row[3]*9.6/100+$row[3];
        echo '
        <!-- <p>Subtotal before tax (' . $row[1] . ' orders): </p>
        <p class="cost">₹' . $row[1] . ' </p>-->
        
        <p>Tax (9.6%)</p>
        <p class="cost">₹' . $tax . ' </p>
        <hr>
        <p>Subtotal:</p>
        <p class="cost">₹' . $subtotal . ' </p>             
        </div>
        </div>';
    
        //calculate total
        $total += $subtotal;

?>
<div id="finalPrice" class = "orderSummary menuItem col-md-6 col-md-offset-2">
    <h5 class="total">Total price:</h5>
    <?php echo '<p class="total cost">₹' . number_format($total, 2) . ' </p>' ?>
    <br><input type="button" name="login" value="Back" class="btn btn-light" onclick="window.location.href='home.php'">
    </div>
    <?php } ?>
<?php include 'includes/footer.php';?>

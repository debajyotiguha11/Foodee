<?php
/**
 *
 * home.php displays all orders of the customer.
 *
 */
session_start();
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
if(isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant'])) {
	header("Location: restaurant/index.php");
}
include 'includes/header.php';
include 'includes/navigation.php';
include_once 'connection/connect.php';

if (isset($_GET['pid'])) {
if(isset($_SESSION['user_id']) && !isset($_SESSION['user_restaurant'])) {
$id = $_GET['pid'];
$cid = $_SESSION['user_id'];
$sql = "UPDATE orders SET pay = 1 WHERE cid = '$cid' and oid='$id'";
mysqli_query($conn, $sql);
header("location: home.php");
}
}

if (isset($_GET['cid'])) {
if(isset($_SESSION['user_id']) && !isset($_SESSION['user_restaurant'])) {
$id = $_GET['cid'];
$cid = $_SESSION['user_id'];
$sql = "DELETE FROM orders WHERE cid = '$cid' and oid='$id'";
mysqli_query($conn, $sql);
header("location: home.php");
}
}
?>

    <div class="col-sm-9">
      <h2>My Orders</h2>
      <div id="update" class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Restaurant</th>
        <th>Item</th>
        <th>Type</th>
        <th>Date</th>
        <th>Paid</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    	$sql = "SELECT o.oid, r.name, m.item, m.preference, o.date, o.pay FROM restaurants r, orders o, menu m, customers c WHERE o.mid = m.mid and o.cid = c.cid and r.rid = m.rid and o.cid = '" . $_SESSION['user_id']. "' ORDER BY o.oid";
    	$result = mysqli_query($conn, $sql);
    	while($r = mysqli_fetch_array($result)) 
        { ?>
      <tr>
        <td><?php echo $r[0] ?></td>
        <td><?php echo $r[1] ?></td>
        <td><?php echo $r[2] ?></td>
        <td><?php if($r[3]==1) echo 'Veg'; else echo 'Non-Veg'?></td>
        <td><?php echo $r[4] ?></td>
        <td><?php if($r[5] == 0) echo "Unpaid"; else echo "Paid"; ?></td>
        <?php if($r[5] == 0) {?><td><a href="home.php?pid=<?php echo $r[0] ?>" class="btn btn-success btn-xs" onclick="return confirm('Confirm Payment?')">Pay</a> <a href="home.php?cid=<?php echo $r[0] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure For Cancel?')">Cancel</a></td><?php } else {?>
<td><a href="receipt.php?oid=<?php echo $r[0]?>" class="btn btn-primary btn-xs">Receipt</a> <a href="home.php?cid=<?php echo $r[0] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure For Cancel?')">Cancel</a> <?php } ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>

<?php
include 'includes/footer.php';

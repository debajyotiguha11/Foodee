<?php
/**
 *
 * home.php is used to display all the orders to the restaurant.
 *
 */
session_start();
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_restaurant'])) {
	header("Location: index.php");
}

include 'includes/header.php';
include 'includes/navigation.php';
include_once '../connection/connect.php';

?>

    <div class="col-sm-9">
      <h2>All orders</h2>
      <div id="update" class="table-responsive">          
  <table class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Item</th>
        <th>Date</th>
        <th>Paid</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    	$sql = "SELECT o.oid, c.name, c.phone, c.address, m.item, o.date, o.pay FROM orders o, menu m, customers c, restaurants r WHERE o.mid = m.mid and o.cid = c.cid and r.rid = m.rid and m.rid='" . $_SESSION['user_id']. "'";
    	$result = mysqli_query($conn, $sql);
    	while($r = mysqli_fetch_array($result)) 
        { ?>
      <tr>
        <td><?php echo $r[0] ?></td>
        <td><?php echo $r[1] ?></td>
        <td><?php echo $r[2] ?></td>
        <td><?php echo $r[3] ?></td>
        <td><?php echo $r[4] ?></td>
        <td><?php echo $r[5] ?></td>
        <td><?php if($r[6] == 0) echo "Unpaid"; else echo "Paid"; ?></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  </div>
</div>

<?php
include '../includes/footer.php';

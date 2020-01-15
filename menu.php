<?php
/**
 *
 * menu.php used to display the menu which is prefered by the customers using this app.
 *
 */
session_start();
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
if(isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant'])) {
	header("Location: restaurant/menu.php");
}
include 'includes/header.php';
include 'includes/navigation.php';
include_once 'connection/connect.php';

$error = false;
if (isset($_POST['submit'])) {
    if(!isset($_POST['orders']))
    	$message = "Select item first";
    else{
    foreach($_POST['orders'] as $o){
    $cid = $_SESSION['user_id'];
    $mid = $o;
    $pay = 0;
    
    if (!$error) {
        $sql = "INSERT INTO orders(mid,cid,pay) VALUES('$mid','$cid','$pay')";
	if(mysqli_query($conn, $sql)) {
			$message = "Successfully ordered!";
			header("location: home.php");
		} else {
		        $error = true;
			$message = "Error!";
		}
	}
	
	}
    
    }
}

?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="col-sm-9">
<h2>Todays Menu</h2>
<div id="update" class="table-responsive">
<form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">          
  <table id="data_table" class="table">
    <thead>
      <tr>
      	<th>Kitchen</th>
        <th>Item</th>
        <th>Type</th>
        <th>Description</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php
    if($_SESSION['preference'] == 2){
    	$sql = "SELECT m.mid, r.name, m.item, m.preference, m.description, m.price FROM menu m, restaurants r WHERE m.rid = r.rid";
    }
    else{
    	$preference = $_SESSION['preference'];
    	$sql = "SELECT m.mid, r.name, m.item, m.preference, m.description, m.price FROM menu m, restaurants r WHERE m.rid = r.rid and m.preference = $preference";
    	}
    	$result = mysqli_query($conn, $sql);
    	while($r = mysqli_fetch_array($result)) 
        { ?>
      <tr>
      	<td><?php echo $r[1] ?></td>
        <td><?php echo $r[2] ?></td>
        <td><?php if($r[3]==1) echo 'Veg'; else echo 'Non-Veg' ?></td>
        <td><?php echo $r[4] ?></td>
        <td><?php echo $r[5] ?></td>
        <td><input type="checkbox" name="orders[]" value="<?php echo $r[0] ?>"></td>
</td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php $result = mysqli_query($conn, $sql);
  $r = mysqli_fetch_array($result);
  if($r) {?>
  <input type="submit" name="submit" value="Order" class="btn btn-success " onclick="return confirm('Are You Sure For order?')">
  <div class="error"><?php if(isset($message)) echo $message; } ?></div>
</form>
</div>

<?php
include 'includes/footer.php';

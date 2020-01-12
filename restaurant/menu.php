<?php
/**
 *
 * menu.php is used to display and add new item to the menu.
 *
 */
session_start();
if(!isset($_SESSION['user_id'])) {
	header("Location: index.php");
}
include 'includes/header.php';
include 'includes/navigation.php';
include_once '../connection/connect.php';

$error = false;
if (isset($_POST['submit'])) {
    $uid = $_SESSION['user_id'];
    $item = $_POST['item'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $preference = $_POST['preference'];
    
    if (!$error) {
        $sql = "INSERT INTO menu(rid,item,preference,description,price) VALUES('$uid','$item','$preference','$description','$price')";
	if(mysqli_query($conn, $sql)) {
			$message = "Successfully Updated!";
			header("location: menu.php");
		} else {
		        $error = true;
			$message = "Error!";
		}
	}
}

if (isset($_GET['id'])) {
if(isset($_SESSION['user_id']) && isset($_SESSION['user_restaurant'])) {
$id = $_GET['id'];
$uid = $_SESSION['user_id'];
$sql = "DELETE FROM menu WHERE rid = '$uid' and mid='$id'";
mysqli_query($conn, $sql);
header("location: menu.php");
}
}

?>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<div class="col-sm-9">
      <h2>My menu</h2>
      <h6>Click on the element to edit</h6>
      <div class="table-responsive">          
  <table id="data_table" class="table">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Type</th>
        <th>Description</th>
        <th>Price</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    <?php 
    	$sql = "SELECT * FROM menu WHERE rid = '" . $_SESSION['user_id']. "'";
    	$result = mysqli_query($conn, $sql);
    	while($r = mysqli_fetch_array($result)) 
        { ?>
      <tr id="<?php echo $r[0]; ?>">
        <td><?php echo $r[0] ?></td>
        <td><?php echo $r[2] ?></td>
        <td><?php if($r[3]==1) echo 'Veg'; else echo 'Non-Veg'; ?></td>
        <td><?php echo $r[4] ?></td>
        <td><?php echo $r[5] ?></td>
        <td><a href="menu.php?id=<?php echo $r[0] ?>" class="btn btn-danger btn-xs" onclick="return confirm('Are You Sure For Delete?')">Delete</a>
</td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <button type="button" class="btn btn-success " data-toggle="modal" data-target="#myModal">Add item</button>
</div>

<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Add new item</h4>
        </div>
        <div class="modal-body">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'];?>">
          <p><input type="text" name="item" placeholder="Item name" required></p>
          <p><textarea name="description" placeholder="Description" required></textarea></p>
          <p><input type="number" name="price" min=1 placeholder="Price" required></p>
          <p>Veg <input type="radio" value="1" name="preference" required> Non-Veg <input type="radio" value="0" name="preference"></p>
        </div>
        <div class="modal-footer">
                    <input type="submit" name="submit" class="btn btn-success" value="Add item">
         </form>
        </div>
      </div>
      
    </div>
  </div>
  </div>

<script type="text/javascript" src="../js/jquery.tabledit.min.js"></script>
<script>
$(document).ready(function(){
$('#data_table').Tabledit({
deleteButton: false,
editButton: false,
columns: {
identifier: [0, 'id'],
editable: [[1, 'item'], [3, 'description'], [4, 'price']]
},
hideIdentifier: false,
url: 'live_edit.php'
});
});
</script>
  
<?php
include 'includes/footer.php';

<?php
/**
 *
 * order.php script used to order the perticular food selected by the user in the index.php page.
 *
 */
 
include_once 'connection/connect.php';
session_start();

if(!isset($_SESSION['user_id']) || isset($_SESSION['user_restaurant'])) {
	header("Location: index.php");
}
$error = false;
if (isset($_POST['order']) && isset($_SESSION['user_id'])) {
	$c = $_POST['count'];
	$mid = $_POST['mid'];
	$m = unserialize(base64_decode($mid));
	print $m;
	for ($i = 0; $i < $c; $i++){
		$cid = $_SESSION['user_id'];
    		$id = $m[$i];
    		$pay = 0;
    		echo $cid.$id;
    		
    		if (!$error) {
        		$sql = "INSERT INTO orders(mid,cid,pay) VALUES('$id','$cid','$pay')";
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
?>

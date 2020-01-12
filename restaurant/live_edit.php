<?php
/**
 *
 * live_edit.php is used to edit item data through jQuery.
 *
 */
include_once("../connection/connect.php");
session_start();
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_restaurant'])) {
	header("Location: index.php");
}

$input = filter_input_array(INPUT_POST);
if ($input['action'] == 'edit') {
$update_field='';
if(isset($input['item'])) {
$update_field.= "item='".$input['item']."'";
} else if(isset($input['description'])) {
$update_field.= "description='".$input['description']."'";
} else if(isset($input['price'])) {
if($input['price'] > 0)
$update_field.= "price='".$input['price']."'";
}
if($update_field && $input['id']) {
$sql_query = "UPDATE menu SET $update_field WHERE mid='" . $input['id'] . "'";
mysqli_query($conn, $sql_query) or die("database error:". mysqli_error($conn));
}
}
?>

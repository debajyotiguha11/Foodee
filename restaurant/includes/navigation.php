<?php
if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_restaurant'])) {
	header("Location: ../index.php");
}
?>
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav" id="navigation">
    <h4>Welcome back <?php $name = explode(" ",$_SESSION['user_name']); echo $name[0]; ?></h4>
    <h6><?php echo $_SESSION['user_email'];?></h6>
      <ul class="nav nav-pills nav-stacked">
        <li class="active"><a href="../index.php">Home</a></li>
        <li><a href="home.php">All orders</a></li>
        <li><a href="menu.php">My menu</a></li>
        <li><a href="settings.php">Settings</a></li>
        <li><a href="logout.php">Logout</a></li>
        <li><a href="javascript:void(0);" class="icon" onclick="myFunction()">
    <i class="fa fa-bars"></i>
  </a></li>
      </ul><br>
    </div>

<script>
function myFunction() {
  var x = document.getElementById("navigation");
  if (x.className === "col-sm-3 sidenav") {
    x.className += " responsive";
  } else {
    x.className = "col-sm-3 sidenav";
  }
}
</script>

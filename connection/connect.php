<?php
date_default_timezone_set("Asia/Kolkata");
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'remotemysql.com');
define('DB_USERNAME', 'y8IYlrRFzu');
define('DB_PASSWORD', 'vLXJDtyjxw');
define('DB_NAME', 'y8IYlrRFzu');
 
/* Attempt to connect to MySQL database */
$conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
 
// Check connection
if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}
?>

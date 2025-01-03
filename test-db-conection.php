<?php
$servername = "localhost";
$username = "root";
$password = "password";
// Creat connection 
$conn = mysqli_connect($servername,$username,$password);
//check connection
if (!$conn) {
die("Connection failed: " .
mysql_connect_error());
}
echo "connected successfully\n";
?>

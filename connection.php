<?php
$servername="localhost";
$username="root";
$password="";
$database="logindetails";
$con=mysqli_connect($servername, $username, $password, $database);
//$con=mysqli_connect("localhost","root","",
if(!$con)
{
    die("error detected".mysqli_error($con));
}
else
{
    echo"connection stablished successfully"
}
?>
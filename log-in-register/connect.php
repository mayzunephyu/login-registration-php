<?php
$server= "localhost";
$hostname="root";
$password="";
$dbname="login_registration_system";
$dbconnection= mysqli_connect($server,$hostname,$password,$dbname,3308);

if($dbconnection == true){
//     echo"successfully connected to database";
 }
else{
 die("error: ". mysqli_connect_error());
}

<?php

$servername = "localhost";
$dbname = "donartus_hirewise3";
$username = "donartus_user";
$password = "donartusdbpass";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn) {

die(" PROBLEM WITH CONNECTION : " . mysqli_connect_error());

}
  
?>
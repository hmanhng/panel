<?php

$servername = "localhost";
$dbname = "hmanhngm_db";
$username = "hmanhngm_db";
$password = "hmanhngm_db";

$conn = mysqli_connect($servername,$username,$password,$dbname);

if(!$conn) {

die(" PROBLEM WITH CONNECTION : " . mysqli_connect_error());

}
  
?>
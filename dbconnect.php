<?php
$host = "localhost";
$username = "mis21037";
$password = "wSiAbFB6vtzpW4qn";
$db = "mis21037";

// Create connection
$conn = mysqli_connect($host, $username, $password, $db);
mysqli_set_charset($conn,"utf8");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
} 

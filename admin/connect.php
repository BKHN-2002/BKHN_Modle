<?php

require_once '../modle/DB.php';
//  $servername = "localhost";
//  $username = "root";
//  $password = "";
//  $dbname = "moodledb";
//  $conn = mysqli_connect($servername, $username, $password, $dbname);
$conn = $connection ;
if (!$conn)
     die("Connection Error : " . mysqli_connect_error());

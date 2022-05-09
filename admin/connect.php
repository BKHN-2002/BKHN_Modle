<?php

require_once '../modle/DB.php';
$conn = $connection ;
if (!$conn)
    die("Connection Error : " . mysqli_connect_error());

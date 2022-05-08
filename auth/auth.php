<?php

$username = $_SESSION['username'];


function isAdmin($connection)
{
    global $username;
    $query = "SELECT * FROM `admins`";
    $dat = mysqli_query($connection, $query);
    $res = mysqli_fetch_all($dat);
    foreach ($res as $key => $value) {
        if ($value[0] == $username) {
            return true;
        }
    }
    return false;
}



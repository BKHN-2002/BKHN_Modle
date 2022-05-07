<?php
    $connection = mysqli_connect('localhost','root','','moodledb');
    if(mysqli_connect_error()){
        echo 'database erorr '.mysqli_connect_error();
    }
?>
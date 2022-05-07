<?php
session_start();

if (isset($_SESSION['adminLogin'])) {

    header("Location:../admin/home.php");
}else{
}
if (isset($_SESSION['username'])){
    $instructorId=$_SESSION['username'];
    if (substr($_SESSION['username'], 0, 1) == 2) {
        header("Location:../instructor/instructor.php?id=$instructorId");
    }elseif (substr($_SESSION['username'], 0, 1) == 1){
        header("Location:../student/student.php?id=$instructorId");

    }
}
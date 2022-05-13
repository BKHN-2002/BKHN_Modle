<?php
session_start();

if (isset($_SESSION['adminLogin'])) {

    header("Location:../admin/home.php");
}else{
    header("Location:../logIn_register/login.php");
}
if (isset($_SESSION['username'])){
    $instructorId=$_SESSION['username'];
    if (substr($_SESSION['username'], 0, 1) == 2) {
        header("Location:../instructor/instructor.php");
    }elseif (substr($_SESSION['username'], 0, 1) == 1){
        header("Location:../student/Student.php");

    }
}
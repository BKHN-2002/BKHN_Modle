<?php
session_start();
include_once "../../modle/DB.php";
$student=$_GET['id'];
$id=$_GET['quizId'];
$sql = "INSERT INTO `quizzesgrades`(`quizId`, `studentId`, `grade`) VALUES ('$id','$student',0)";
$result = mysqli_query($connection, $sql);
echo $student;
header("Location:../student.php");
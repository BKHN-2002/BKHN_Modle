<?php
require_once "connect.php";

$id = $_GET['stdId'];
$sql = "DELETE FROM `student_course` WHERE studentId = " . $id;
if (mysqli_query($conn, $sql)) {
    header('Location:deleteStdFromCourseFirstPart.php');
    exit();
} else
    echo "Error";

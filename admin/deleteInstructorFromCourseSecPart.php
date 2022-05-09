<?php
require_once "connect.php";

$id = $_GET['instructorID'];
$sql = "DELETE FROM `instructor_course` WHERE  instructorID = " . $id;
if (mysqli_query($conn, $sql)) {
    header('Location:deleteInstructorFromCourseFirstPart.php');
    exit();
} else
    echo "Error";

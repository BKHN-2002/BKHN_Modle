<?php
require_once "connect.php";

$id = $_GET['instructorID'];
$courseId=$_GET['courseId'];
$sql = "DELETE FROM `instructor_course` WHERE  instructorID = " . $id ." && courseId=".$courseId;
if (mysqli_query($conn, $sql)) {
    header('Location:deleteInstructorFromCourseFirstPart.php');
    exit();
} else
    echo "Error";

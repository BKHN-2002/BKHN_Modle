<?php

include_once "../../modle/DB.php";
$fileName = $_GET['fileName'];
$courseId=$_GET['courseId'];
$instructorID=$_GET['id'];
$query = mysqli_query($connection,
    "INSERT INTO `courses_content`(`courseId`, `instructorId`, `contains`, `type`) VALUES
                        ($courseId,$instructorID,'".$fileName."','file')");
//echo "INSERT INTO `courses_content`(`courseId`, `instructorId`, `contains`, `type`) VALUES
//                        ($courseId,$instructorID,'".$fileName."','file')";
header("Location:courseInstructor.php?courseId=$courseId&instructorId=$instructorID");
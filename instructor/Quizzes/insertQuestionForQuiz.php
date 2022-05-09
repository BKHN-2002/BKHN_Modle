<?php
include "../../modle/DB.php";

$quizId = $_GET['quizId'];
$Qustion = $_GET['question'];
$Answer1 = $_GET['ans1'];
$Answer2 = $_GET['ans2'];
$Answer3 = $_GET['ans3'];
$Answer4 = $_GET['ans4'];
$checkbox1 = $_GET['check1'];
$checkbox2 = $_GET['check2'];
$checkbox3 = $_GET['check3'];
$checkbox4 = $_GET['check4'];

//insert qustion in table qustionquize

$query = "INSERT INTO selectquise(qustion, quizId) VALUES ('$Qustion',$quizId)";
mysqli_query($connection, $query);
$idQustion = mysqli_insert_id($connection);

$addDataToStudent = "INSERT INTO answerqustion(anser, qustionid , iansernumber) VALUES ('$Answer1',$idQustion,$checkbox1);";
$addDataToStudent .= "INSERT INTO answerqustion(anser, qustionid , iansernumber) VALUES ('$Answer2',$idQustion,$checkbox2);";
$addDataToStudent .= "INSERT INTO answerqustion(anser, qustionid , iansernumber) VALUES ('$Answer3',$idQustion,$checkbox3);";
$addDataToStudent .= "INSERT INTO answerqustion(anser, qustionid , iansernumber) VALUES ('$Answer4',$idQustion,$checkbox4);";
mysqli_multi_query($connection, $addDataToStudent);

header("Location:addQustionToQuize.php?id=$quizId");


exit();

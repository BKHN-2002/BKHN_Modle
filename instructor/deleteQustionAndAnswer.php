<?php
include_once("../modle/DB.php");
$idQuze = $_GET['idQuize'];
$idQustion = $_GET['id'];
$query = "DELETE FROM  answerqustion WHERE qustionid =$idQustion;";
mysqli_query($connection, $query);
$query1 = "DELETE FROM selectquise WHERE id=$idQustion;";
mysqli_query($connection, $query1);
header("location:showQustioninQuize.php?id=$idQuze");

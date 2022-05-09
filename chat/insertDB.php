<?php
session_start();
include_once("../modle/DB.php");
$id = $_SESSION['username'];
$idStudent = $_SESSION['idStudent'];

if (substr($id, 0, 1) == 2) {
//

    $sql = "INSERT INTO `message`(`instructorId`, `studentID`, `msgText`,`createdAt`,`sender`, `reciver`) " .
        "VALUES (" .
        "" . $id . "," .
        "" . $idStudent . "," .
        "'" . $_GET['message'] . "'," .
        "'" . date("h:i:s a") . "'," .
        "'" . $id . "'," .
        "'" . $idStudent . "'" .
        ");";

    mysqli_query($connection, $sql);
    header("Location:chat.php?id=$idStudent");
    unset($_SESSION["chat"]);



} else if (substr($id, 0, 1) == 1) {
//    unset($_SESSION["chat"]);
    $sql = "INSERT INTO `message`(`instructorId`, `studentID`, `msgText`,`createdAt`,`sender`, `reciver`) " .
        "VALUES (" .
        "" . $idStudent . "," .
        "" . $id . "," .
        "'" . $_GET['message'] . "'," .
        "'" . date("h:i:s a") . "'," .
        "'" . $id . "'," .
        "'" . $idStudent . "'" .
        ");";

    mysqli_query($connection, $sql);
    header("Location:chat.php?id=$idStudent");
    unset($_SESSION["chat"]);


}
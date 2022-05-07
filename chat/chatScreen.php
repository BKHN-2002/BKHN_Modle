<?php
session_start();
require_once("../modle/DB.php");
$id = $_SESSION['username'];
if (substr($id, 0, 1) == 2) {
    $firstNumber = substr($id, 0, 1);
    $sql = "SELECT * FROM student_course where instructorID=$id";
    $result = mysqli_query($connection, $sql);
} else if (substr($id, 0, 1) == 1) {
    $sql = "SELECT * FROM student_course where studentId=$id";
    $result = mysqli_query($connection, $sql);
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" />
    <title>Chat</title>
</head>

<body>
<table>
    <tr><th>Name</th></tr>
    <?php
    if (substr($id, 0, 1) == 2) {
        $array = array();
        while ($row = mysqli_fetch_assoc($result)){
            $array[$row['studentId']] = '';
        }
        foreach ($array as $k=>$v){
            echo '<tr>';
            $statement = "SELECT distinct name from student where id= $k";
            $re = mysqli_query($connection, $statement);
            $a = mysqli_fetch_assoc($re);
            $name = $a['name'];
            echo "<td> <a href='chat.php?id=$k'>$name </td>";
            echo '</tr>';
        }

    } else if (substr($id, 0, 1) == 1) {
        $array = array();
        while ($row = mysqli_fetch_assoc($result)){
            $array[$row['instructorID']] = '';
        }
        foreach ($array as $k=>$v){
            echo '<tr>';
            $statement = "SELECT distinct name from instructor where id= $k";
            $re = mysqli_query($connection, $statement);
            $a = mysqli_fetch_assoc($re);
            $name = $a['name'];
            echo "<td> <a href='chat.php?id=$k'>$name </td>";
            echo '</tr>';
        }
    }

    ?>

</table>
</body>

</html>
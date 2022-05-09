<?php
session_start();
include_once("../../modle/DB.php");
if (isset($_POST['answer'])) {
    mysqli_query($connection, "INSERT INTO `answerassignment`(`assignmentId`, `studentId`, `answer`, `grade`) 
                            VALUES (" . $_GET['assignmentId'] . "," . $_SESSION['username'] . ",'" . $_POST['answer'] . "',-1)");
    header("LOCATION:../Student.php");
}
?>
<!doctype html>
<html lang="en">
<head>
    <title>Assignment</title>
    <link rel="stylesheet" href="../../style/formStyle.css">
    <link rel="stylesheet" href="../../style/tableStyle.css">
    <style>
        .disclaimer{
            display : none;
        }
        a {
            padding: 10PX;
            margin: 20px;
        }
        .demo{
            margin: auto;
            width: 50%;
            border: 3px solid black;
            padding: 10px;
            text-align: center;
            font-size: 35px;
        }


    </style>
</head>
<body>
<?php
$query = mysqli_query($connection, "select endTime, startTime from assignment 
                where id=" . $_GET['assignmentId']);
$res3 = $query->fetch_all();
$endTimeOfAssignment = $res3[0][0];
$startTimeOfAssignment = $res3[0][1];
date_default_timezone_set("Asia/Jerusalem");


if ($startTimeOfAssignment > date("Y-m-d H:i:s")) {
    $timestamp = strtotime($startTimeOfAssignment);

    $day = date('l', $timestamp);
    echo "<div class='demo'>";
    echo "<p style='color:red'> sorry this assignment open in $day  $startTimeOfAssignment.</p>";
    echo "</div>";
    // $sql = "INSERT INTO `answerassignment`(`assignmentId`, `studentId`, `answer`, `grade`) VALUES ('" . $_GET['assignmentId'] . "','" . $_SESSION['username'] . "','',0)";
    // $result = mysqli_query($connection, $sql);

} else {
    if ($endTimeOfAssignment < date("Y-m-d H:i:s")) {
        echo "<div class='demo'>";
        echo "<p style='color:red'> sorry this assignment left.</p>";
        echo "</div>";

    }else{
        ?>

        <h2>Assignment</h2>
        <p style="padding-left: 20PX; font-size: 16px">
        <table>
            <tr><th>Description: </th></tr>
        </table>
        <h3></h3>
        <?PHP
        $query = mysqli_query($connection, "select descrption from assignment where id=" . $_GET['assignmentId']);
        $row = mysqli_fetch_assoc($query);
        echo $row['descrption'];
        ?>
        </p>
        <br>
        <p style="padding-left: 20PX; font-size: 16px">
        <table>
            <tr><th>Questions:</th></tr>
        </table>
        <h3></h3>

        <?php
        $query = mysqli_query($connection, "select qustion from assignment where id=" . $_GET['assignmentId']);
        $row = mysqli_fetch_assoc($query);
        echo $row['qustion'];
        ?>

        </p>
        <?php

        $query = mysqli_query($connection, "select file from assignment where id=" . $_GET['assignmentId']);
        $row = mysqli_fetch_assoc($query);
        if ($row['file'] != ''):
            $nameFile = $row['file'];
            // echo $nameFile;
            echo "<a href='../Store/upload/$nameFile'><h1>Download File</h1></a>";
            ?>

        <?php endif; ?>
        <?php
        $query = mysqli_query($connection, "select * from answerassignment 
                where assignmentId=" . $_GET['assignmentId'] . " and studentId=" . $_SESSION['username']);
        if (mysqli_num_rows($query) == 0):
            ?>
            <form method="post" style="padding: 20PX; font-size: 20px">
                <br>
                <label for="answer"><h2>Answer: </h2></label>
                <br>
                <textarea cols="150" rows="9" id="answer" name="answer" style="width: 100%"> </textarea>
                <input type="submit" name="submit" value="submit">
            </form>
        <?php else: ?>
            <div class='demo'>
                <p style="color:red"> sorry you already solve this assignment.</p>
            </div>
        <?php endif; ?>
        <?php

    }
}
?>


</body>
</html>
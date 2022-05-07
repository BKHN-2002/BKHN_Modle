<?php
include_once("../modle/DB.php");
session_start();
$instructorId = $_SESSION['username'];

$myName = "";

if (substr($instructorId, 0, 1) == 2) {
    $name = "SELECT name from instructor where id= $instructorId";
    $myName = mysqli_query($connection, $name);
} else {
    $name = "SELECT name from student where id= $instructorId";
    $myName = mysqli_query($connection, $name);
}

$myName = mysqli_fetch_assoc($myName)["name"];

$_SESSION["myName"] = $myName;

$_SESSION["chat"] = 1;



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" type="text/css" href="../style/master.css" />
    <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" />
    <style>
        .cahtUi {
            margin: auto;
            width: 50%;
            border: 1px solid #4c92dd;
            padding: 10px;
            text-align: center;
            height: 100%;
        }

        .message {
            text-align: left;
            height: 90%;
        }

        .col-75 {
            display: flex;
        }
    </style>
</head>

<body style="overflow: visible">

<div class="cahtUi">
    <!--    <p>Chat UI</p>-->
    <div class="message">
        <table id="chat-table">
            <tr>
                <th style="text-align: center">Chat UI</th>
            </tr>
            <?php
            include_once("../modle/DB.php");
            $id = $_SESSION['username'];
            $idStudent = $_GET['id'];
            $_SESSION['idStudent'] = $idStudent;

            if (substr($id, 0, 1) == 2) {
                $sql = "SELECT * FROM `message` WHERE `instructorId`= $id and `studentID`= $idStudent ORDER BY createdAt ASC ";
                $result = mysqli_query($connection, $sql);
                while ($a = mysqli_fetch_assoc($result)) {

                    if ($a['sender'] == $id) {
                        $nameInstructor = "SELECT name from instructor where id= $id";
                        $r = mysqli_query($connection, $nameInstructor);
                        while ($n = mysqli_fetch_assoc($r)) {
                            echo "<tr>";
                            echo '<td>' . $n['name'] . " : " . $a['msgText'] . '</td>';
                            echo "</tr>";
                        }
                    } else {
                        $idStudent = $a['sender'];
                        $name = "SELECT name from student where id= $idStudent";
                        $r = mysqli_query($connection, $name);
                        while ($n = mysqli_fetch_assoc($r)) {
                            echo "<tr>";
                            echo '<td>' . $n['name'] . " : " . $a['msgText'] . '</td>';
                            echo "</tr>";
                        }
                    }
                }
            } else if (substr($id, 0, 1) == 1) {

                $sql = "SELECT * FROM `message` WHERE `instructorId`= $idStudent and `studentID`= $id ORDER BY createdAt ASC";
                $result = mysqli_query($connection, $sql);
                ?>

                <?php



                while ($a = mysqli_fetch_assoc($result)) {

                    if ($a['sender'] == $id) {
                        $nameInstructor = "SELECT name from student where id= $id";
                        $r = mysqli_query($connection, $nameInstructor);
                        while ($n = mysqli_fetch_assoc($r)) {
                            echo "<tr>";
                            echo '<td>' . $n['name'] . " : " . $a['msgText'] . '</td>';
                            echo "</tr>";
                        }
                    } else {
                        $idStudent = $a['sender'];
                        $name = "SELECT name from instructor where id= $idStudent";
                        $r = mysqli_query($connection, $name);
                        while ($n = mysqli_fetch_assoc($r)) {
                            echo "<tr>";
                            echo '<td>' . $n['name'] . " : " . $a['msgText'] . '</td>';
                            echo "</tr>";
                        }
                    }
                }
            }
            ?>
        </table>
    </div>


    <form ">
    <div class=" row">
        <div class="row">
            <div class="col-75">
                <input type="text" id="msg" name="message" required />
                <input type="button" onclick="sendMsg('<?php echo $_SESSION["myName"] ?>')" name="send" value="Send" style="margin-left: 15px">
            </div>
        </div>

    </div>

    </form>
    <div class="insid">
        <?php
        if (substr($id, 0, 1) == 2) {
            echo " <a href='../instructor/instructor.php?id=$id'>Back</a>";
        } else if (substr($id, 0, 1) == 1) {
            echo " <a href='../student/Student.php?id=$id'>Back</a>";
        }
        ?>

    </div>

    <script>
        const msgInput = document.getElementById("msg")
        const chatTable = document.querySelector("#chat-table tbody")
        let isGray = true;

        function sendMsg(name) {
            fetch(`insertDB.php?message=${msgInput.value}`);
            /* location.reload() */
            chatTable.innerHTML += `<tr><td>${name} : ${msgInput.value}</td></tr>`
            msgInput.value = "";

        }
    </script>

</body>

</html>
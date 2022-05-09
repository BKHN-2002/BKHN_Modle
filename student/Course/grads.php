<?php
require_once "../../modle/DB.php";

$stdId = $_GET['stdId'];
$courseId = $_GET['couseId'];
$quizeSql = "SELECT `quizId`,  `grade` FROM `quizzesgrades` WHERE `studentId` = " . $stdId;
$assignmentSql = "SELECT `assignmentId`, `grade` FROM `answerassignment` WHERE  `studentId` = " . $stdId;
$stdSql = "SELECT `name` FROM `student` WHERE `id` = " . $stdId;
$courseSql = "SELECT  `name` FROM `courses` WHERE `id` = " . $courseId;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Grads </title>
    <style>
        .container {
            padding: 70px;
        }

        .container .info-container {
            width: 100%;
            padding: 15px 20px;
            border-radius: 20px;
            background-color: #ddd;

        }

        .container .info {
            width: 80%;
            display: flex;
            justify-content: space-between;
            gap: 50px;
            margin: auto;
        }

        .container span {
            text-transform: capitalize;
                color: #187ae2;

        }

        table {
            width: 90%;
            margin: 30px auto;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #adadf6;
        }

        tr:nth-child(odd) {
            background-color: #ddd;
        }

        th {
            background-color: #9933ff;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container">
        <?php
        //getting student name 
        $stdSqlResult = mysqli_query($connection, $stdSql);
        $row = mysqli_fetch_assoc($stdSqlResult);
        $stdName = $row['name'];
        //gitting course name 
        $courseSqlResult = mysqli_query($connection, $courseSql);
        $row1 = mysqli_fetch_assoc($courseSqlResult);
        $courseName = $row1['name'];
        ?>

        <div class="info-container ">
            <div class="info">
                <h2>Your Grades : <span> <?php echo $stdName;  ?></span></h2>
                <h2>Course Name : <span> <?php echo $courseName;  ?></span></h2>
            </div>
        </div>


        <table>
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Name </th>
                    <th>Your Grade</th>
                </tr>
            </thead>
            <tbody>

                <?php
                $quizeSqlResult = mysqli_query($connection, $quizeSql);
                while ($row = mysqli_fetch_assoc($quizeSqlResult)) {
                    $quizId = $row['quizId'];
                    $grade = round($row['grade'], 4);
                    echo "<tr>";
                    echo "<td> Quize  </td>";
                    echo "<td> Quize " . $quizId . "</td>";
                    echo "<td>" . $grade * 100 . "%</td>";
                    echo "</tr>";
                }

                $assignmentSqlResult = mysqli_query($connection, $assignmentSql);
                while ($row = mysqli_fetch_assoc($assignmentSqlResult)) {
                    $assignmentId = $row['assignmentId'];
                    $grade = $row['grade'];
                    if ($grade != -1) {
                        $grade = round($grade, 4) * 100 . "%";
                    } else {
                        $grade = "Not Graded";
                    }
                    echo "<tr>";
                    echo "<td> Assignment   </td>";
                    echo "<td> Assignment " . $assignmentId . "</td>";
                    echo "<td>" . $grade . "</td>";
                    echo "</tr>";
                }

                ?>
            </tbody>
        </table>
    </div>
</body>

</html>
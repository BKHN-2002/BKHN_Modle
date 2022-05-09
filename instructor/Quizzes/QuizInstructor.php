<?php
session_start();
include_once("../../modle/DB.php");
$instructorId=$_SESSION['username'];
$quizId=$_GET['quizId'];
$courseID=$_GET['courseId'];
?>
<!doctype html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../../style/tableStyle.css" />
    <title>show all Student</title>
</head>
<body>
<h2>Quizzes</h2>
<table>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>Grade</th>
    </tr>
    <?php
    $sql="SELECT DISTINCT student.id,student.name,quizzesgrades.grade
                    FROM student JOIN quizzesgrades JOIN quizzes
                    on student.id = quizzesgrades.studentId and quizzesgrades.quizId =$quizId
                    WHERE quizzes.instructorId =$instructorId and quizzes.courseId =$courseID";
    // $sql = "SELECT DISTINCT `studentId`  FROM `student_course`" ;
    $result=mysqli_query($connection,$sql);
        while ($row=mysqli_fetch_assoc($result)){
            $idStudent=$row['id'];
            $nameStudent=$row['name'];
            $gradeStudent=$row['grade']*100;
            echo "<tr>";
            echo "<td> $idStudent</td>";
            echo "<td> $nameStudent</td>";
            echo "<td> $gradeStudent</td>";
            echo "</tr>";
        }
    ?>
</body>

</html>

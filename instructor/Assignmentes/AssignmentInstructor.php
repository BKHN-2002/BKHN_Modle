<?php
session_start();
include_once("../../modle/DB.php");
$instructorId=$_SESSION['username'];
$assignmentId=$_GET['assignmentId'];
$courseID=$_GET['courseId'];
?>
<!doctype html>
<html>

<head>
    <link rel="stylesheet" type="text/css" href="../../style/tableStyle.css" />

</head>
<body>
<h2>Assignments</h2>
<table>
    <tr>
        <th>Student ID</th>
        <th>Student Name</th>
        <th>Answer</th>
        <th>Grade</th>
        <th>Action</th>
    </tr>
    <?php
    $sql="SELECT DISTINCT answerassignment.assignmentId, answerassignment.studentId as id, answerassignment.answer as answer,answerassignment.grade from answerassignment JOIN assignment
                        WHERE answerassignment.assignmentId=$assignmentId AND assignment.coursesId= $courseID AND assignment.instructorId=$instructorId";
        $result=mysqli_query($connection,$sql);

        while ($row=mysqli_fetch_assoc($result)){
            $idStudent=$row['id'];
            $answerStudent=$row['answer'];
            $gradeStudent=$row['grade'];
            echo "<tr>";
            echo "<td>". $idStudent."</td>";
            echo "<td>". getNameById($connection,$idStudent)."</td>";
            echo "<td>". $answerStudent."</td>";
            echo "<td>". $gradeStudent."</td>";
            echo "<td>"."<a href='updateGrade.php?studentId=$idStudent&assignmentId=$assignmentId&courseId=$courseID'> Update" ."</td>";
            echo "</tr>";
        }
//    echo  "ss";
    ?>
</body>

</html>

<?php
function getNameById($connection,$idStudent){
    $sql="SELECT name from student where id = $idStudent";
    $result=mysqli_query($connection,$sql);
    while ($row=mysqli_fetch_assoc($result)){
        return $row['name'];
    }
}
?>


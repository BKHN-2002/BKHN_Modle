<?php
session_start();
if (isset($_SESSION['updated'])){
    include_once("../../modle/DB.php");
    $assignmentId=$_GET['assignmentId'];

    $studentId=$_GET['studentId'];
    $courseId=$_GET['courseId'];
    if (isset($_POST["submit"])) {
        $grade=$_POST['grade'];
        $sql =
            "UPDATE answerassignment SET grade =
               $grade
                WHERE studentId= $studentId
               and assignmentId= $assignmentId";
        $result=mysqli_query($connection,$sql);
        header("Location:AssignmentInstructor.php?assignmentId=$assignmentId&courseId=$courseId");
        unset($_SESSION["updated"]);
//        destroy($_SESSION["updated"]);
//        session_
        exit();

    }
}else{
    $instructorId=$_SESSION['username'];
    header("Location:../instructor.php");
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../../style/master.css">
</head>

<body>
<h2>Update Grade</h2>
<div class="container">
    <form method="POST" action="" >

  <div class="row">
            <div class="col-25">
                <label for="grade">Grade</label>
            </div>
            <div class="col-75">
                <input type="text" name="grade" required />
            </div>
        </div>

        <br>
        <div class="row">
            <input type="submit" name="submit" value="Update">
        </div>
    </form>
</div>

</body>

</html>

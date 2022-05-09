<?php

session_start();
include_once("../../modle/DB.php");
$instructorId = $_SESSION['username'];
$echoCourseExist = " ";

if (isset($_POST['submit'])) {
    if (!empty($_POST['coursId']) && !empty($_POST['stdId'])) {
        $idstudent = $_POST['stdId'];
        $idcourse = $_POST['coursId'];
        $queryInsert = "INSERT INTO student_course (instructorID, studentId, courseId) VALUES ($instructorId, $idstudent, $idcourse);";
        mysqli_query($connection, $queryInsert);
    }
    header("Location:../instructor.php");
}


//select course
$sql = "SELECT  courses.name as coursName,courses.id as courseId
    from courses JOIN instructor join instructor_course
    on instructor_course.instructorID = instructor.id
    WHERE instructor_course.instructorID = $instructorId;";
$result = mysqli_query($connection, $sql);

//select student
$sql1 = "SELECT * from student";
$result1 = mysqli_query($connection, $sql1);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../style/formStyle.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            text-align: center;
            margin: auto;
            padding: 100px;
        }

        .inlininstyle {
            width: max-content;
            height: auto;
            font-size: 20px;
            min-width: 18%;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <form action="" method="post">
                <div class="stdId-container form-group">
                    <label style="font-size: 20px; padding:20px;" class="label" for="">Course ID : </label>
                    <div class="form-group">
                        <select class="inlininstyle" name="coursId">
                            <?php
                            if (mysqli_num_rows($result) > 0) {
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $courseId = $row['courseId'];
                                    $courseName = $row['coursName'];
                                    echo "<option value='$courseId'>$courseId - $courseName </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="stdId-container form-group">
                    <label style="font-size: 20px; padding:20px;" class="label" for="">Student ID : </label>
                    <div class="ct-select-group ct-js-select-group">
                        <select class="ct-select ct-js-select inlininstyle" name="stdId">
                            <?php
                            if (mysqli_num_rows($result1) > 0) {
                                while ($row = mysqli_fetch_assoc($result1)) {
                                    $stdId = $row['id'];
                                    $stdName = $row['name'];
                                    echo "<option value='$stdId'>$stdId - $stdName </option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <h4 class="state">
                    <?php echo $echoCourseExist; ?>
                </h4>
                <input class="sbmit inlininstyle" type="submit" name="submit" value="Add" style="max-width: 18%; min-width: 200px;">
            </form>
        </div>
    </div>
</body>

</html>
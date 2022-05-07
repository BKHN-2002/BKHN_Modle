<?php
session_start();
include_once "../modle/DB.php";
if (isset($_POST['submit'])) {
    $courseId = substr($_POST['courseId'], 0, 3);
    $stratTime = strtotime($_POST["timeStartQuize"]);
    $stratTime = date('Y-m-d H:i:s', $stratTime);
    $endTime = strtotime($_POST["timeEndQuize"]);
    $endTime = date('Y-m-d H:i:s', $endTime);
    $instructorId = $_SESSION['username'];

    //INSERT INTO `quizzes`(`id`, `instructorId`, `courseId`, `startTime`, `endTime`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]')
    $sql = "INSERT INTO `quizzes`(`id`, `instructorId`, `courseId`, `startTime`, `endTime`) VALUES ('','$instructorId','$courseId','$stratTime','$endTime')";
    mysqli_query($connection,$sql);

    header("Location:addQuestionForQuiz.php?courseId=$courseId");
}
?>
<!doctype html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../style/formStyle.css">
    <meta charset="UTF-8">
    <title>Add Quiz</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            max-width: max-content;
            margin: auto;
            padding: 100px;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>
<body>
<form action="" method="post">
    <label><h1>Add Quiz</h1></label>

    <select name="courseId" id="courseId">
        <?php
        //        echo "<option>".'20'."</option>";
        $query = mysqli_query($connection, "select instructor_course.courseId as courseId,courses.name as courseName from instructor_course join courses on instructor_course.courseId = courses.id
                                            where instructor_course.instructorID = " . $_SESSION['username']);
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<option>" . $row['courseId'] . " - " . $row['courseName'] . "</option>";
        }
        ?>
    </select>
    <div style="--><?php // if(isset($_POST['submitCourse'])&&!empty($_POST['timeQuize'])){echo 'visibility: hidden';}?><!--"
         class="form-group">
        <label><h3>Add Start Time of Quize</h3></label>
        <input type="datetime-local" id="start" name="timeStartQuize" style="width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;">
    </div>
    <div style="--><?php // if(isset($_POST['submitCourse'])&&!empty($_POST['timeQuize'])){echo 'visibility: hidden';}?><!--"
         class="form-group">
        <label><h3>Add End Time of Quize</h3></label>
        <input type="datetime-local" id="start" name="timeEndQuize" style="width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;">
    </div>
    <input type="submit" name="submit" value="submit">
</form>
</body>
</html>
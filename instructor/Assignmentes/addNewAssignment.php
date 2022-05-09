<?php
session_start();
include_once("../../modle/DB.php");
$hint = '';
if (isset($_POST['submit'])) {
    unset($_SESSION["assignment"]);
    header("LOCATION:../instructor.php");
    $fileName = rand() . $_FILES['file']['name'];
    $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    $array = array('pdf', 'docx', 'pptx', '');
    $stratTime = strtotime($_POST["timeStartQuize"]);
    $stratTime = date('Y-m-d H:i:s', $stratTime);
    $endTime = strtotime($_POST["timeEndQuize"]);
    $endTime = date('Y-m-d H:i:s', $endTime);
    if (in_array($fileExtension, $array)) {
        if ($fileExtension == '') $fileName = null;
        move_uploaded_file($_FILES['file']['tmp_name'],'..\..\Store\\'.$fileName);
        $courseId = substr($_POST['courseId'], 0, 3);
        //INSERT INTO `assignment`(`id`, `qustion`, `descrption`, `coursesId`, `instructorId`, `file`, `startTime`, `endTime`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]','[value-8]')
        mysqli_query($connection, "INSERT INTO `assignment`(`qustion`, `descrption`, `coursesId`, `instructorId`, `file`,`startTime`, `endTime`)
            VALUES  ('" . $_POST['question'] . "','" . $_POST['description'] . "'," . $courseId . "," . $_SESSION['username'] .
            ",'" . $fileName . "','" . $stratTime . "','" . $endTime . "');");
    } else {
        $hint = 'The file must have the extension pdf, txt, dcox or pptx';
    }
}


?>
<html>

<head>
    <link rel="stylesheet" href="../../style/formStyle.css">
    <title>Add Assignment</title>
    <style>
        body {
            background-color: #c5c5f6;
        }

        .container {
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Add new assignment</h1>
        <form method="POST" enctype="multipart/form-data">

            <label for="courseId">Course ID</label>
            <select name="courseId" id="courseId">
                <?php
                //        echo "<option>".'20'."</option>";
                $query = mysqli_query($connection, "select instructor_course.courseId as courseId,courses.name as courseName from instructor_course join courses on instructor_course.courseId = courses.id
                                    where instructor_course.instructorID = " . $_SESSION['username']);
                while ($row = mysqli_fetch_assoc($query)) {
                    echo "<option>" . $row['courseId'] . " - " . $row['courseName'] . "</option>";
                }
                ?>

            </select><br>
            <div style="--><?php // if(isset($_POST['submitCourse'])&&!empty($_POST['timeQuize'])){echo 'visibility: hidden';}
                            ?><!--" class="form-group">
                <label>
                    <h3>Add Start Time of Quize</h3>
                </label>
                <input type="datetime-local" id="start" name="timeStartQuize" style="width: 100%;
padding: 12px 20px;
margin: 8px 0;
display: inline-block;
border: 1px solid #ccc;
border-radius: 4px;
box-sizing: border-box;">
            </div>
            <div style="--><?php // if(isset($_POST['submitCourse'])&&!empty($_POST['timeQuize'])){echo 'visibility: hidden';}
                            ?><!--" class="form-group">
                <label>
                    <h3>Add End Time of Quize</h3>
                </label>
                <input type="datetime-local" id="start" name="timeEndQuize" style="width: 100%;
padding: 12px 20px;
margin: 8px 0;
display: inline-block;
border: 1px solid #ccc;
border-radius: 4px;
box-sizing: border-box;">
            </div>
            <br>
            <label for="description">Description</label>
            <br>
            <textarea cols="150" rows="9" id="description" name="description" style="width: 100%"> </textarea>
            <br>
            <br>
            <label for="question">Questions</label>
            <br>
            <textarea cols="200" rows="10" id="question" name="question" style="width: 100%"> </textarea>
            <br>
            <br>
            <label for="file">add file</label>
            <input type="file" id="file" name="file">
            <br>
            <br>

            <input type="submit" style="background-color: #9933ff;" name="submit" value="submit">
        </form>

    </div>

</body>

</html>
<?php
session_start();
include_once('../../modle/DB.php');
$courseID = $_GET['courseId'];
$instructorID = $_GET['instructorId'];
$id = $_SESSION['username'];
$sqlCourse = mysqli_query(
    $connection,
    "SELECT * FROM courses WHERE id= $courseID"
);
$courseName = $sqlCourse->fetch_assoc();

$sqlInstructor = mysqli_query(
    $connection,
    "SELECT * FROM instructor WHERE id= $instructorID"
);
$instructorName = $sqlInstructor->fetch_assoc();

if (isset($_POST['text_submit']) && $_POST['text'] != '') {
    $textStyle = $_POST['textStyle'];
    $query = mysqli_query(
        $connection,
        "INSERT INTO `courses_content`(`courseId`, `instructorId`, `contains`, `type`) VALUES
                        ($courseID,$instructorID,'<$textStyle>" . $_POST['text'] . "</$textStyle>','text')"
    );
} elseif (isset($_POST['file_submit']) && $_FILES['file']['name'] != null) {
    $fileName = rand(1000000000, 9999999999) . $_FILES['file']['name'];
    $extension = pathinfo($fileName, PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['file']['tmp_name'], '..\Store\\' . $fileName);
    header("Location:insertFile.php?courseId=$courseID&id=$instructorID&fileName=$fileName");
}
if (isset($_GET['contentIdForDelete'])) {
    mysqli_query($connection, "delete from courses_content where id=" . $_GET['contentIdForDelete']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../../style/tableStyle.css" />
    <link rel="stylesheet" type="text/css" href="../../style/formStyle.css" />
    <title>Course Content</title>
    <style>
        .container {
            text-align: center;
        }

        .center {
            margin-left: auto;
            margin-right: auto;
        }

        * {
            text-transform: capitalize;
        }

        .content-header {
            overflow: hidden;
        }

        h3 {
            color: #343a40;
            font-weight: 600;
            font-size: 24px;
            padding-left: 30px;
        }

        .content-header .information-container .infos {
            padding: 0px;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            align-items: center;
        }

        .content-header .information-container .box {
            margin: 10px 20px;
            background-color: #adadf6;
            color: white;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            padding: 20px;
            width: 28%;
        }

        .content-header .information-container .box h4 {
            font-weight: 700;
            color: black;
        }

        .content-header .information-container .box p {
            padding: 0 20px;
            font-weight: 700;
        }

        .pinbox {
            text-align: center;
            width: 70%;
            font-size: 24px;
        }

        body {
            background-color: #f2f1f1b8;
            margin-top: 0;
        }

        a {
            border: none;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            transition-duration: 0.4s;
            cursor: pointer;
            background-color: white;
            color: black;
            width: 176px !important;
        }

        a:hover {
            background-color: #adadf6;
            color: white;
        }

        .insid {
            margin-top: 25px;
            text-align: right;
        }

        #text {
            color: white;
            line-height: 50px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #c5c5f6;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            margin-top: 0;
        }

        .container h1 {
            text-transform: capitalize;
            font-weight: 800;
            font-family: Arial, Helvetica, sans-serif;
            color: white;
        }

        .container .info-container {
            width: 90%;
            margin: 0 auto;
            padding: 15px 20px;
        }

        .main-container {
            padding: 40px;
            background-color: #c5c5f6;
            margin: 40px 0px 0;
            border-radius: 20px;
        }


        h3 {
            width: 100% !important;
            color: white;
            text-align: center;
            padding: 22px 0;
            margin: 20px 0 0;
            background-color: #9933ff;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            text-transform: uppercase;
        }

        th {
            background-color: #adadf6;
        }

        input[type=submit] {
            background-color: white;
            color: #adadf6;
        }

        input[type=submit]:hover {
            background-color: #adadf6;
            color: white;
        }
    </style>
    <meta name="viewport" content="width=device-width" />

</head>

<body>
    <div class="container">
        <div class="info-container">
            <h1 id="text">
                <h1><?php
                    echo $courseName['name'] . ' course';
                    ?></h1>
                <h1><?php
                    echo 'instructor name: ' . $instructorName['name'];
                    ?></h1>
                <div class="insid">
                    <a href="../instructor.php?id= <?php echo $instructorID ?> ">Back</a>
                </div>
        </div>
    </div>

    <div class="main-container">
        <div class="content-header">
            <div class="information-container">
                <h3>Course & Instructor Information: </h3>
                <div class="infos">
                    <div class="box">
                        <p style="font-size: 15.2px">number of students in this Course with <?php echo $instructorName['name'] ?></p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM student_course WHERE instructorID=$instructorID and courseId=" . $courseID;
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?>
                        </p>
                    </div>

                    <div class="box">
                        <p>number of students in this Course</p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM student_course WHERE instructorID=$instructorID";
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?>
                        </p>
                    </div>

                    <div class="box">
                        <p>number of courses for <?php echo $instructorName['name'] ?> </p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM instructor_course WHERE instructorID=$instructorID";
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?> </p>
                    </div>
                    <div class="box">
                        <p>number of instructor who teach <?php echo $courseName['name'] ?></p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM instructor_course WHERE courseId=$courseID";
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?> </p>
                    </div>
                    <br>
                    <div class="box" class="box">
                        <p>number of quizzes in <?php echo $courseName['name'] ?> with <?php echo $instructorName['name'] ?></p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM quizzes WHERE instructorId=$instructorID and courseId=$courseID";
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?> </p>
                    </div>
                    <div class="box" class="box">
                        <p>number of assignments in <?php echo $courseName['name'] ?> with <?php echo $instructorName['name'] ?></p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM assignment WHERE instructorId=$instructorID and coursesId=$courseID";
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?> </p>
                    </div>

                </div>
            </div>
        </div>
        <h3>Content course:</h3>
        <table>
            <tr>
                <th>content</th>
                <th>type</th>
                <th>delete</th>
            </tr>
            <?php
            $query = mysqli_query($connection, "select * from courses_content where courseId=$courseID and instructorId=$instructorID");
            while ($row = mysqli_fetch_assoc($query)) {
                echo "<tr>";
                if ($row['type'] == 'text') {
                    echo "<td>" . $row['contains'] . "</td>";
                } else {
                    echo "<td>" . substr($row['contains'], 10) . "</td>";
                }
                echo "<td>" . $row['type'] . "</td>";
                $contentId = $row['id'];
                echo "<td><a href='courseInstructor.php?courseId=$courseID&instructorId=$instructorID&contentIdForDelete=$contentId'>delete</a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <form enctype="multipart/form-data" method="post">
            <input type="file" name="file">
            <input type="submit" name="file_submit" value="add file" style="width: 100px">
            <textarea style="width: 100%" rows="5" name="text"></textarea>
            text Style
            <select style="width: 10%" name="textStyle">
                <option value="p">normal</option>
                <option value="i">italic</option>
                <option value="b">bold</option>
                <option value="h1">head 1</option>
                <option value="h2">head 2</option>
                <option value="h3">head 3</option>
                <option value="h4">head 4</option>
                <option value="h5">head 5</option>
                <option value="h6">head 6</option>
            </select>

            <input type="submit" name="text_submit" value="add text">
        </form>
    </div>
</body>

</html>
<?php
session_start();
include_once('../modle/DB.php');
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

if(isset($_POST['text_submit']) && $_POST['text'] != ''){
    $textStyle = $_POST['textStyle'];
    $query = mysqli_query($connection,
        "INSERT INTO `courses_content`(`courseId`, `instructorId`, `contains`, `type`) VALUES
                        ($courseID,$instructorID,'<$textStyle>".$_POST['text']."</$textStyle>','text')");
}elseif (isset($_POST['file_submit']) && $_FILES['file']['name'] != null){
    $fileName = rand(1000000000,9999999999).$_FILES['file']['name'];
    $extension = pathinfo($fileName,PATHINFO_EXTENSION);
    move_uploaded_file($_FILES['file']['tmp_name'],'..\Store\\'.$fileName);
    header("Location:insertFile.php?courseId=$courseID&id=$instructorID&fileName=$fileName");
}
if(isset($_GET['contentIdForDelete'])){
    mysqli_query($connection,"delete from courses_content where id=".$_GET['contentIdForDelete']);

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
            justify-content: space-evenly;
            align-items: center;
            display: flex;
        }

        .content-header .information-container .box {
            margin: 10px 20px;
            padding: 10px 10px;
            background-color: #4c92dd;
            color: white;
            border-radius: 20px;
            display: flex;
            justify-content: space-evenly;
            align-items: flex-start;
            flex-direction: column;
        }

        .content-header .information-container .box h4 {
            font-weight: 700;
            color: black;
        }

        .content-header .information-container .box p {
            padding: 0 20px;
            font-weight: 700;
        }
        .box{
            font-size: 16px;text-align: center;width: 70%;
        }
        .pinbox{
            text-align: center;
            width: 70%;
            font-size: 24px;
        }





        /* @media screen and (min-width:761px) {
            .content-header .information-container .box {
                    margin: 10px 20px;
                    padding: 10px 10px;
                    background-color: #4c92dd;
                    color: white;
                    border-radius: 20px;
                    width: 100%;
                    display: flex;
                    justify-content: space-evenly;
                    align-items: flex-start;
                    flex-direction: column;
                }
        }
        */




    </style>
    <meta name="viewport" content="width=device-width"/>
    <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" />
    <link rel="stylesheet" type="text/css" href="../style/formStyle.css" />
</head>

<body>
<div class="container">
    <h1><?php
        echo $courseName['name'] . ' course';
        ?></h1>
    <h1><?php
        echo 'instructor name: ' . $instructorName['name'];
        ?></h1>

</div>
<div class="insid">
    <a href="instructor.php?id= <?php echo $instructorID?> ">Back</a>
</div>

<div class="content-header">
    <div class="information-container">
        <h3>Course & Instructor Information: </h3>
        <div class="infos">
            <div class="box" >
                <p style="font-size: 15.2px">number of students in this Course with <?php echo $instructorName['name'] ?></p>
                <p class="pinbox"><?php
                    $sql="SELECT * FROM student_course WHERE instructorID=$instructorID and courseId=".$courseID;
                    $result=mysqli_query($connection,$sql);
                    echo mysqli_num_rows($result);
                    ?>
                </p>
            </div>

            <div class="box" >
                <!--                    <h4 style="padding-left: 20px">Student Information : </h4>-->
                <p>number of students in this Course</p>
                <p class="pinbox"><?php
                    $sql="SELECT * FROM student_course WHERE instructorID=$instructorID";
                    $result=mysqli_query($connection,$sql);
                    echo mysqli_num_rows($result);
                    ?>
                </p>
                <!--                        <p>number of student who has a courses : --><?php //echo $numOfStdWhoHasCourse ?><!-- </p>-->
            </div>

            <div class="box">
                <!--                    <h4>course Inforamtions : </h4>-->
                <p>number of courses for <?php echo $instructorName['name'] ?> </p>
                <p class="pinbox" ><?php
                    $sql="SELECT * FROM instructor_course WHERE instructorID=$instructorID";
                    $result=mysqli_query($connection,$sql);
                    echo mysqli_num_rows($result);
                    ?> </p>
            </div>
            <div class="box" >
                <!--                    <h4>course Instructors : </h4>-->
                <p>number of instructor who teach <?php echo $courseName['name'] ?></p>
                <p class="pinbox" ><?php
                    $sql="SELECT * FROM instructor_course WHERE courseId=$courseID";
                    $result=mysqli_query($connection,$sql);
                    echo mysqli_num_rows($result);
                    ?> </p>
            </div>
            <br>
            <div class="box" class="box">
                <!--                    <h4>course Instructors : </h4>-->
                <p>number of quizzes in <?php echo $courseName['name'] ?> with <?php echo $instructorName['name'] ?></p>
                <p class="pinbox"><?php
                    $sql="SELECT * FROM quizzes WHERE instructorId=$instructorID and courseId=$courseID";
                    $result=mysqli_query($connection,$sql);
                    echo mysqli_num_rows($result);
                    ?> </p>
            </div>
            <div class="box" class="box">
                <!--                    <h4>course Instructors : </h4>-->
                <p>number of assignments in <?php echo $courseName['name'] ?> with <?php echo $instructorName['name'] ?></p>
                <p class="pinbox"><?php
                    $sql="SELECT * FROM assignment WHERE instructorId=$instructorID and coursesId=$courseID";
                    $result=mysqli_query($connection,$sql);
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
    $query = mysqli_query($connection,"select * from courses_content where courseId=$courseID and instructorId=$instructorID");
    while ($row = mysqli_fetch_assoc($query)){
        echo "<tr>";
        if($row['type'] == 'text') {
            echo "<td>" . $row['contains'] . "</td>";
        }else{
            echo "<td>" . substr($row['contains'],10) . "</td>";
        }
        echo "<td>".$row['type']."</td>";
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

</body>

</html>
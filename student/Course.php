<?php
session_start();
include_once('../modle/DB.php');
// include_once('Student.php');
// echo 

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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Content</title>
    <style>
        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        i,
        b,
        p,
        a {
            margin-left: 20px
        }

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



        .content-header .information-container {
            margin: 50px 20px;
            width: 40%;
            display: flex;
            justify-content: center;
            flex-direction: column;
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
            margin: 50px 350px;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
        }

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

        .content-header .information-container .box h4 {
            font-weight: 700;
            color: black;
        }

        .content-header .information-container .box p {
            padding: 0 20px;
            font-weight: 700;
        }

        .box {
            font-size: 16px;
            text-align: center;
            width: 70%;
        }

        .pinbox {
            text-align: center;
            width: 70%;
            font-size: 24px;
        }

        @media screen and (max-width:480px) {

            .content-header .information-container .infos {
                padding: 0px;
                width: 100%;
                margin: 50px 80px;
                justify-content: space-evenly;
                align-items: center;
                flex-direction: column;
            }

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
    </style>
    <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" />
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
<div class="grads-container">
    <div class="insid">
        <a href= '<?php echo "grads.php?stdId=" . $id . "&couseId=".$courseID;?>'>Your Grads</a>
    </div>

</div>
<div class="content-header">
    <div class="information-container">
        <h3>Course & Instructor Information: </h3>
        <div class="infos">

            <div class="box" class="box">
                <!--                    <h4>course Instructors : </h4>-->
                <p>number of quizzes in <?php echo $courseName['name'] ?> with <?php echo $instructorName['name'] ?></p>
                <p class="pinbox"><?php
                    $sql = "SELECT * FROM quizzes WHERE instructorId=$instructorID and courseId=$courseID";
                    $result = mysqli_query($connection, $sql);
                    echo mysqli_num_rows($result);
                    ?> </p>
            </div>
            <div class="box" class="box">
                <!--                    <h4>course Instructors : </h4>-->
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
<hr>

<h3>content:</h3>


<?php
$query = mysqli_query($connection, "select * from courses_content where courseId=$courseID and instructorId=$instructorID");
while ($row = mysqli_fetch_assoc($query)) {
    if ($row['type'] == 'text') {
        echo "<p style='width: 95%;overflow: auto;'>" . $row['contains'] . "</p>";
    } else if ($row['type'] == 'file') {
        $fileName = $row['contains'];
        echo "<br><a style='margin-left: 20px' href='../Store/$fileName'>" . (substr($row['contains'], 10)) . "</a>";
    }
}
?>

</body>

</html>
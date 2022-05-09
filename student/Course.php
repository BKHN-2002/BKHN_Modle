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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Content</title>
    <style>
        * {
            text-transform: capitalize;
        }

        .container {
            text-align: center;
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

        .content .content-info {
            padding: 20px;
        }

        .content-header .information-container {
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            flex-direction: column;
        }

        .content-header .information-container .infos {
            padding: 0px;
            width: 100%;
            display: flex;
            justify-content: space-evenly;
            align-items: center;
            margin: 20px 0;
        }

        .content-header .information-container .box {
            margin: 0px 20px;
            background-color: #adadf6;
            color: white;
            border-radius: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            width: fit-content;
            padding: 20px;
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


        @media (max-width:480px) {
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
</head>

<body>

    <div class="container">
        <div class="info-container">
            <h1 id="text">
                <?php
                echo $courseName['name'] . ' course';
                echo "<br>";
                echo 'instructor name: ' . $instructorName['name'];
                ?></h1>
            <div class="insid">
                <a href='<?php echo "grads.php?stdId=" . $id . "&couseId=" . $courseID; ?>'>Your Grads</a>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="content-header">
            <div class="information-container">
                <h3>Course & Instructor Information: </h3>
                <div class="infos">
                    <div class="box">
                        <p>number of quizzes in <?php echo $courseName['name'] ?> with <?php echo $instructorName['name'] ?></p>
                        <p class="pinbox"><?php
                                            $sql = "SELECT * FROM quizzes WHERE instructorId=$instructorID and courseId=$courseID";
                                            $result = mysqli_query($connection, $sql);
                                            echo mysqli_num_rows($result);
                                            ?> </p>
                    </div>
                    <div class="box">
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
        <div class="content">
            <h3>content:</h3>
            <div class="content-info">
                <?php
                $query = mysqli_query($connection, "select * from courses_content where courseId=$courseID and instructorId=$instructorID");
                while ($row = mysqli_fetch_assoc($query)) {
                    if ($row['type'] == 'text') {
                        echo "<p style='width: 95%; margin:auto ;'>" . $row['contains'] . "</p>";
                    } else if ($row['type'] == 'file') {
                        $fileName = $row['contains'];
                        echo "<br><a style='margin-left: 20px' href='../Store/$fileName'>" . (substr($row['contains'], 10)) . "</a>";
                    }
                }
                ?>
            </div>
        </div>
    </div>


</body>

</html>
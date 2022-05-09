<?php
session_start();
include "../modle/DB.php";
if (isset($_SESSION['username'])) {
    $instructorId = $_SESSION['username'];
    if (substr($_SESSION['username'], 0, 1) == 2) {

        $insId = $_SESSION['username'];
        $_SESSION["updated"] = 1;
        unset($_SESSION["chat"]);
        $query_insName = mysqli_query($connection, "SELECT name from instructor where id=$insId");
    } elseif (substr($_SESSION['username'], 0, 1) == 1) {
        header("Location:../student/student.php");
    } else {
        $query = "SELECT * FROM `admins`";
        $dat = mysqli_query($connection, $query);
        $res = mysqli_fetch_all($dat);
        foreach ($res as $key => $value) {
            if ($value[0] == $_SESSION['username']) {
                header("location:../admin/home.php");
                exit();
            }
        }
    }
} else {
    header("Location:../logIn_register/login.php");
}

if (isset($_GET['hideAssignmentId'])) {
    mysqli_query($connection, "update assignment set visibility = 0 where id=" . $_GET['hideAssignmentId']);
} else if (isset($_GET['viewAssignmentId'])) {
    mysqli_query($connection, "update assignment set visibility = 1 where id=" . $_GET['viewAssignmentId']);
}


if (isset($_GET['hideQuizId'])) {
    mysqli_query($connection, "update quizzes set visibility = 0 where id=" . $_GET['hideQuizId']);
} else if (isset($_GET['viewQuizId'])) {
    mysqli_query($connection, "update quizzes set visibility = 1 where id=" . $_GET['viewQuizId']);
}



?>
<html>

<head>

    <style>
        #links {
            background-color: #04AA6D;
            color: white;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition-duration: 0.4s;
            cursor: pointer;
            background-color: white;
            color: black;
            width: 183px !important;
        }

        #links:hover {
            background-color: #adadf6;
            color: white;
        }

        body {
            background-color: #f2f1f1b8;
            margin-top: 0;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 0;
            border-bottom-right-radius: 10px;
            border-bottom-left-radius: 10px;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: center;
            width: 400px !important;
        }

        tr:hover {
            background-color: #d9e1f0;
            border-radius: 20px;
        }


        th {
            background-color: #adadf6;
            color: white;
            padding: 18px;
            font-size: 20px;
        }

        a {
            background-color: #04AA6D;
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

        .disclaimer {
            display: none;
        }

        .insid {
            margin-top: 25px;
            text-align: right;
        }

        #text {
            margin-right: 50%;
            color: white;
        }

        .container .info {
            width: 80%;
            display: flex;
            justify-content: space-between;
            gap: 50px;
            margin: auto;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #9933ff;
            border-bottom-left-radius: 20px;
            border-bottom-right-radius: 20px;
            margin-top: 0;
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

        h1 {
            text-transform: capitalize;
            font-weight: 800;
            font-family: Arial, Helvetica, sans-serif;
        }

        h2 {
            color: white;
            text-align: center;
            padding: 22px 0;
            margin: 20px 0 0;
            background-color: #9933ff;
            border-top-right-radius: 10px;
            border-top-left-radius: 10px;
            text-transform: uppercase;
        }

        .add {
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .add a {
            display: block;
            padding: 20px 10px;
            border-radius: 10px;
        }

        .main-container a {
            border-radius: 10px;
        }
    </style>
    <!-- <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" /> -->
</head>

<body>
    <div class="container">
        <div class="info-container">
            <h1 id="text">
                <?php
                echo "Welcome Dr." . mysqli_fetch_assoc($query_insName)['name']
                ?></h1>
            <div class="insid">
                <a id="links" href="Course/addStudentToCourse.php">Add Student to Course</a>
                <a id="links" href="../chat/chatScreen.php">Chat</a>
                <a id="links" href="Quizzes/showCourses.php">Show all Quizz</a>
                <a id="links" href="../logIn_register/logout.php">LogOut</a>
            </div>
        </div>
    </div>

    <div class="main-container">
        <h2>Courses</h2>
        <table>
            <tr>
                <th>course name</th>
                <th>instructor name</th>
                <th>course detailes</th>
            </tr>
            <?php
            $query_insCourse = mysqli_query(
                $connection,
                "SELECT DISTINCT courses.name as coursesName,
                            instructor.name as instructorName,
                            courses.id as courseId,
                            instructor.id as instructorId
                            from instructor_course join courses JOIN instructor
                            on instructor_course.instructorID = instructor.id and instructor_course.courseId = courses.id 
                            WHERE instructor_course.instructorID = $insId"
            );


            while ($row = mysqli_fetch_assoc($query_insCourse)) {
                $courseId = $row['courseId'];
                $instructorId = $row['instructorId'];
                echo "<tr>";
                echo "<td>" . $row['coursesName'] . "</td>";
                echo "<td> Dr." . $row['instructorName'] . "</td>";
                echo "<td> <a href='Course/courseInstructor.php?courseId=$courseId&instructorId=$instructorId'>go to course</a> </td>";
                echo "</tr>";
            }
            ?>
        </table>

        <h2>Quizzes</h2>
        <table>
            <tr>
                <th>Quiz name</th>
                <th>action</th>
                <th>edit date</th>
                <th>visibility</th>
            </tr>
            <?php
            $query_insQuiz = mysqli_query(
                $connection,
                "SELECT  quizzes.name as courseNameQuiz, quizzes.id as quizId,courses.id as courseId , quizzes.visibility as visibility
                            from quizzes JOIN courses join instructor_course
                            on quizzes.courseId = courses.id 
                            and quizzes.instructorId = instructor_course.instructorID 
                            and quizzes.courseId = instructor_course.courseId
                            WHERE instructor_course.instructorID = $insId"
            );


            while ($row = mysqli_fetch_assoc($query_insQuiz)) {
                $quizId = $row['quizId'];
                $courseID = $row['courseId'];
                echo "<tr>";
                echo "<td>" . $row['courseNameQuiz'] . "</td>";
                echo "<td> <a href='Quizzes/QuizInstructor.php?quizId=$quizId&courseId=$courseID'>show all student</button> </a>";

                $query3 = "SELECT startTime,endTime from quizzes where id=$quizId";
                $dat3 = mysqli_query($connection, $query3);
                $res3 = mysqli_fetch_all($dat3);
                $startTimeOfQuiz = $res3[0][0];
                $endTimeOfQuiz = $res3[0][1];
                $timestamp = strtotime($startTimeOfQuiz);
                $day = date('l', $timestamp);

                $timestampEnd = strtotime($endTimeOfQuiz);
                $dayEnd = date('l', $timestampEnd);
                echo "<td><a href='Date/editDate.php?quizId=$quizId'>" . '<b>Start in:</b> <br>' . $day . ' ' . $startTimeOfQuiz . '  <hr> <b>End in: </b><br>' . $dayEnd . ' '  . $endTimeOfQuiz . "  <img  width='20px' src='../image/pencil.png'></a></td>";


                if ($row['visibility'] != 0) {
                    echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&hideQuizId=$quizId'><img width='40px' src='../image/view.png'></a></td>";
                } else
                    echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&viewQuizId=$quizId'><img width='40px' src='../image/hide.png'></a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <div class="add">
            <a href="Quizzes/addNewQuiz.php">Add new quiz</a>
        </div>

        <h2>Assignmentes</h2>
        <table>
            <tr>
                <th>course name</th>
                <th>action</th>
                <th>edit date</th>
                <th>visibility</th>
            </tr>
            <?php


            $query_insAss = mysqli_query(
                $connection,
                "SELECT  courses.name as courseNameForAssignment ,assignment.id as assignmentId,courses.id as courseId, assignment.visibility as visibility
                            from assignment JOIN courses join instructor_course
                            on assignment.coursesId = courses.id and assignment.instructorId = instructor_course.instructorID 
                            and assignment.coursesId = instructor_course.courseId
                            WHERE instructor_course.instructorID = $insId"
            );


            while ($row = mysqli_fetch_assoc($query_insAss)) {
                $assignmentId = $row['assignmentId'];
                $courseID = $row['courseId'];
                echo "<tr>";
                echo "<td>" . $row['courseNameForAssignment'] . "</td>";
                echo "<td> <a href='Assignmentes/AssignmentInstructor.php?assignmentId=$assignmentId&courseId=$courseID'>show all student</a> </td>";

                $query3 = "SELECT startTime,endTime from assignment where id=$assignmentId";
                $dat3 = mysqli_query($connection, $query3);
                $res3 = mysqli_fetch_all($dat3);
                $startTimeOfAssignment = $res3[0][0];
                $endTimeOfAssignment = $res3[0][1];

                $timestamp = strtotime($startTimeOfAssignment);
                $day = date('l', $timestamp);

                $timestampEnd = strtotime($endTimeOfAssignment);
                $dayEnd = date('l', $timestampEnd);
                echo "<td><a href='Date/editDate.php?assignmentId=$assignmentId'>" . '<b>Start in:</b> <br>' . $day . ' ' . $startTimeOfQuiz . '  <hr> <b>End in: </b><br>' . $dayEnd . ' '  . $endTimeOfQuiz . "  <img  width='20px' src='../image/pencil.png'></a></td>";


                if ($row['visibility'] != 0) {
                    echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&hideAssignmentId=$assignmentId'><img width='40px' src='../image/view.png'></a></td>";
                } else
                    echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&viewAssignmentId=$assignmentId'><img width='40px' src='../image/hide.png'></a></td>";
                echo "</tr>";
            }
            ?>
        </table>
        <div class="add">
            <a href="Assignmentes/addNewAssignment.php">Add new assignment</a>
        </div>
        <br>
    </div>
</body>

</html>

<?php //functions
function getQuizGrade($connection, int $quizId, int $studentId)
{
    $query_gradeQuiz = mysqli_query(
        $connection,
        "SELECT grade from quizzesgrades where quizId=$quizId and studentId=$studentId"
    );
    if ($g = mysqli_fetch_assoc($query_gradeQuiz))
        return 'your grade %' . $g['grade'] * 100;
    else
        return 'you haven\'t solve this quiz yet.';
}
function getAssignmentGrade($connection, int $assignmntId, int $studentId)
{
    $query_gradeQuiz = mysqli_query(
        $connection,
        "SELECT grade from answerassignment where assignmentId=$assignmntId and studentId=$studentId"
    );
    if ($g = mysqli_fetch_assoc($query_gradeQuiz)) {
        if ($g['grade'] == -1) {
            return 'You haven\'t been given a mark yet';
        } else
            return 'your grade ' . $g['grade'];
    } else
        return 'you haven\'t solve this Assignment yet.';
}

?>
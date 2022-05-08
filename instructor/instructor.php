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
        .insid {

            margin-top: 25px;
            width: 350px;
            /* margin-right: 15px; */
        }

        #text {
            margin-right: 40%;
            color: white;
        }

        .disclaimer {
            display: none;
        }

        table td,
        table th {
            text-align: center;
        }


        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            text-align: center;

        }

        tr:hover {
            background-color: rgb(213, 228, 255);
        }


        th {
            background-color: #04AA6D;
            color: white;
            padding: 18px;
            font-size: 20px;
        }

        a {
            background-color: #04AA6D;
            /* border: none; */
            color: white;
            padding: 8px 16px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;

            transition-duration: 0.4s;
            cursor: pointer;
            background-color: white;
            color: black;
            border: 1px solid #04AA6D;
        }

        #links {
            background-color: #04AA6D;
            color: white;
            /* padding: 8px 16px; */
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition-duration: 0.4s;
            cursor: pointer;
            background-color: white;
            color: black;
            /* margin: 4px; */
            border: 1px solid #04AA6D;
            width: 100px;
        }

        #links:hover {
            background-color: #04AA6D;
            color: white;
        }

        a:hover {
            background-color: #04AA6D;
            color: white;
        }

        .container {
            display: flex;
            /* padding: 70px; */
        }

        .container .info {
            width: 80%;
            display: flex;
            justify-content: space-between;
            gap: 50px;
            margin: auto;
        }


        .container .info-container {
            width: 100%;
            padding: 15px 20px;
            border-radius: 20px;
            background-color: #04AA6D;

        }
    </style>
    <!-- <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" /> -->
</head>

<body>
    <div class="container">
        <div class="info-container">

            <div class="info">
                <h1 id="text">
                    <?php
                    echo "Welcome Dr." . mysqli_fetch_assoc($query_insName)['name']
                    ?></h1>
                <div style="width: 100%;" class="insid">
                    <a id="links" href="addStudentToCourse.php">Add Student to Course</a>
                </div>
                <div class="insid">
                    <a id="links" href="../chat/chatScreen.php">Chat</a>
                </div>

                <div class="insid">

                    <a id="links" href="showCourses.php">Show all Quizz</a>
                </div>

                <div class="insid">
                    <a id="links" href="../logIn_register/logout.php">LogOut</a>
                </div>
            </div>
        </div>



    </div>
    <h2>Quizzes</h2>
    <table>
        <tr>
            <th>course name</th>
            <th>action</th>
            <th>edit date</th>
            <th>visibility</th>
        </tr>
        <?php
        $query_insQuiz = mysqli_query(
            $connection,
            "SELECT  courses.name as courseNameQuiz, quizzes.id as quizId,courses.id as courseId , quizzes.visibility as visibility
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
            echo "<td> <a href='QuizInstructor.php?quizId=$quizId&courseId=$courseID'>show all student</button> </a>";

            $query3 = "SELECT startTime,endTime from quizzes where id=$quizId";
            $dat3 = mysqli_query($connection, $query3);
            $res3 = mysqli_fetch_all($dat3);
            $startTimeOfQuiz = $res3[0][0];
            $endTimeOfQuiz = $res3[0][1];
            $timestamp = strtotime($startTimeOfQuiz);
            $day = date('l', $timestamp);

            $timestampEnd = strtotime($endTimeOfQuiz);
            $dayEnd = date('l', $timestampEnd);
            echo "<td><a href='editDate.php?quizId=$quizId'>" . '<b>Start in:</b> <br>' . $day . ' ' . $startTimeOfQuiz . '  <hr> <b>End in: </b><br>' . $dayEnd . ' '  . $endTimeOfQuiz . "  <img  width='20px' src='../image/pencil.png'></a></td>";


            if ($row['visibility'] != 0) {
                echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&hideQuizId=$quizId'><img width='40px' src='../image/view.png'></a></td>";
            } else
                echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&viewQuizId=$quizId'><img width='40px' src='../image/hide.png'></a></td>";
            echo "</tr>";
        }
        ?>


    </table>

    <a href="addNewQuiz.php">Add new quiz</a>
    <br>
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
            echo "<td> <a href='AssignmentInstructor.php?assignmentId=$assignmentId&courseId=$courseID'>show all student</a> </td>";

            $query3 = "SELECT startTime,endTime from assignment where id=$assignmentId";
            $dat3 = mysqli_query($connection, $query3);
            $res3 = mysqli_fetch_all($dat3);
            $startTimeOfAssignment = $res3[0][0];
            $endTimeOfAssignment = $res3[0][1];

            $timestamp = strtotime($startTimeOfAssignment);
            $day = date('l', $timestamp);

            $timestampEnd = strtotime($endTimeOfAssignment);
            $dayEnd = date('l', $timestampEnd);
            echo "<td><a href='editDate.php?assignmentId=$assignmentId'>" . '<b>Start in:</b> <br>' . $day . ' ' . $startTimeOfQuiz . '  <hr> <b>End in: </b><br>' . $dayEnd . ' '  . $endTimeOfQuiz . "  <img  width='20px' src='../image/pencil.png'></a></td>";


            if ($row['visibility'] != 0) {
                echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&hideAssignmentId=$assignmentId'><img width='40px' src='../image/view.png'></a></td>";
            } else
                echo "<td><a style='border: rgba(255,255,255,0);background: #ffffff00' href='instructor.php?id=$insId&viewAssignmentId=$assignmentId'><img width='40px' src='../image/hide.png'></a></td>";
            echo "</tr>";
        }
        ?>
    </table>

    <a href="addNewAssignment.php" onsubmit="<?php
                                                //$_SESSION['assignment']=1;
                                                ?>">Add new assignment</a>
    <br>
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
            echo "<td> <a href='courseInstructor.php?courseId=$courseId&instructorId=$instructorId'>go to course</a> </td>";
            echo "</tr>";
        }
        ?>
    </table>

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
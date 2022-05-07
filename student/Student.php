<?php
session_start();
if (isset($_SESSION['username'])){
    include_once('../modle/DB.php');
    $studentId =$_SESSION['username'];
    unset($_SESSION["chat"]);
    $query_studentName = mysqli_query($connection, "SELECT name from student where id=$studentId");
    $name=$query_studentName->fetch_all()[0][0];
}else{
    header("Location:../logIn_register/login.php");
}


?>
    <html>

    <head>
        <link rel="stylesheet" type="text/css" href="../style/tableStyle.css" />
        <style>
            .disclaimer{
                display : none;
            }
            .container{
                display: flex;
            }
            .insid{

                margin-top: 25px;
                margin-right: 15px;
            }
            #text{
                margin-right: 40%;
            }
        </style>
        <title>Student <?php echo $name ?></title>
    </head>

    <body>
    <div class="container">
        <h1 id="text">
            <?php
            echo "Welcome ". $name
            ?></h1>

        <div class="insid">
            <a href="../chat/chatScreen.php">Chat</a>
        </div>

        <div class="insid">
            <a href="../logIn_register/logout.php">LogOut</a>
        </div>
    </div>
    <h2>Quizzes</h2>
    <table>
        <tr>
            <th>course name</th>
            <th>your grade</th>
            <th>time</th>
            <th>attempt quiz</th>
        </tr>
        <?php

        $query_studentQuiz = mysqli_query(
            $connection,
            "SELECT courses.name as courseNameForQuiz, quizzes.id as quizId ,quizzes.visibility as visibility
                            from quizzes JOIN courses join student_course
                            on quizzes.courseId = courses.id 
                            and quizzes.instructorId = student_course.instructorID 
                            and quizzes.courseId = student_course.courseId
                            WHERE student_course.studentId = $studentId"
        );


        while ($row = mysqli_fetch_assoc($query_studentQuiz)) {

            $quizId = $row['quizId'];
            if($row['visibility'] != 0) {
                $query3 = "SELECT startTime,endTime from quizzes where id=$quizId";
                $dat3 = mysqli_query($connection, $query3);
                $res3 = mysqli_fetch_all($dat3);
                $startTimeOfQuiz = $res3[0][0];
                $endTimeOfQuiz = $res3[0][1];

                $timestamp = strtotime($startTimeOfQuiz);
                $day = date('l', $timestamp);

                $timestampEnd = strtotime($startTimeOfQuiz);
                $dayEnd = date('l', $timestampEnd);
                echo "<tr>";
                echo "<td>" . $row['courseNameForQuiz'] . "</td>";
                echo "<td>" . getQuizGrade($connection, $row['quizId'], $studentId) . "</td>";
                echo "<td>".'<b>Start in:</b> <br>'.$day.' ' . $startTimeOfQuiz.'  <hr> <b>End in: </b><br>'.$dayEnd.' '  .$endTimeOfQuiz.
                    "</td>";
                echo "<td> <a href='Quiz.php?quizId=$quizId'>attempt now</button> </a>";
                echo "</tr>";
            }
        }
        ?>


    </table>
    <br>
    <h2>Assignmentes</h2>
    <table>
        <tr>
            <th>course name</th>
            <th>your grade</th>
            <th>time</th>
            <th>attempt assignment</th>
        </tr>
        <?php
        $query_studentQuiz = mysqli_query(
            $connection,
            "SELECT courses.name as courseNameForAssignment ,assignment.id as assignmentId,assignment.visibility as visibility
                            from assignment JOIN courses join student_course
                            on assignment.coursesId = courses.id and assignment.instructorId = student_course.instructorID 
                            and assignment.coursesId = student_course.courseId
                            WHERE student_course.studentId = $studentId"
        );


        while ($row = mysqli_fetch_assoc($query_studentQuiz)) {
            if($row['visibility'] != 0) {

                $assignmentId = $row['assignmentId'];

                $query3 = "SELECT startTime,endTime from assignment where id=$assignmentId";
                $dat3 = mysqli_query($connection, $query3);
                $res3 = mysqli_fetch_all($dat3);
                $startTimeOfQuiz = $res3[0][0];
                $endTimeOfQuiz = $res3[0][1];

                $timestamp = strtotime($startTimeOfQuiz);
                $day = date('l', $timestamp);

                $timestampEnd = strtotime($endTimeOfQuiz);
                $dayEnd = date('l', $timestampEnd);
                echo "<tr>";
                echo "<td>" . $row['courseNameForAssignment'] . "</td>";
                echo "<td>" . getAssignmentGrade($connection, $row['assignmentId'], $studentId) . "</td>";
                echo "<td>".'<b>Start in:</b> <br>'.$day.' ' . $startTimeOfQuiz.'  <hr> <b>End in: </b><br>'.$dayEnd.' '  .$endTimeOfQuiz.
                    "</td>";
                echo "<td> <a href='Assignment.php?assignmentId=$assignmentId'>attempt now</a> </td>";
                echo "</tr>";
            }
        }
        ?>
    </table>
    <br>
    <h2>Courses</h2>
    <table>
        <tr>
            <th>course name</th>
            <th>instructor name</th>
            <th>course detailes</th>
        </tr>
        <?php
        $query_studentQuiz = mysqli_query(
            $connection,
            "SELECT courses.name as coursesName,
                            instructor.name as instructorName,
                            courses.id as courseId,
                            instructor.id as instructorId
                            from student_course join courses JOIN instructor
                            on student_course.instructorID = instructor.id and student_course.courseId = courses.id 
                            WHERE student_course.studentId = $studentId"
        );


        while ($row = mysqli_fetch_assoc($query_studentQuiz)) {
            $courseId = $row['courseId'];
            $instructorId = $row['instructorId'];
            echo "<tr>";
            echo "<td>" . $row['coursesName'] . "</td>";
            echo "<td> Dr." . $row['instructorName'] . "</td>";
            echo "<td> <a href='Course.php?courseId=$courseId&instructorId=$instructorId'>go to course</a> </td>";
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
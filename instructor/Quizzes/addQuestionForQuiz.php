<?php
session_start();
include_once "../modle/DB.php";
$instructorId = $_SESSION['username'];
$courseId = $_GET['courseId'];
if (isset($_POST['submit'])) {
    $question = $_POST['question'];
    $Answer1 = $_POST['Answer1'];
    $Answer2 = $_POST['Answer2'];
    $Answer3 = $_POST['Answer3'];
    $Answer4 = $_POST['Answer4'];

    if (isset($_POST['checkbox1']) || isset($_POST['checkbox2']) || isset($_POST['checkbox3']) || isset($_POST['checkbox4'])) {
        $checkbox1 = empty($_POST['checkbox1']) ? 0 : 1;
        $checkbox2 = empty($_POST['checkbox2']) ? 0 : 1;
        $checkbox3 = empty($_POST['checkbox3']) ? 0 : 1;
        $checkbox4 = empty($_POST['checkbox4']) ? 0 : 1;

        $result =  mysqli_query($connection, "select id from quizzes where instructorId=$instructorId and courseId=$courseId order by id DESC limit 1");
        $quizId = $result->fetch_all()[0][0];
        $sql = "INSERT INTO `selectquise`(`id`, `qustion`, `quizId`) VALUES ('','$question','$quizId')";
        mysqli_query($connection, $sql);
        $result2 =  mysqli_query($connection, "select id from  selectquise order by id DESC limit 1");
        $quizId2 = $result2->fetch_all()[0][0];
        for ($i = 1; $i <= 4; $i++) {
            $query1 = "SELECT count(*) FROM answerqustion";
            $dat1 = mysqli_query($connection, $query1);
            $res1 = mysqli_fetch_all($dat1);
            $idanswer1 = ($res1[0][0] + 1);
            if ($i == 1) {
                $addDataToStudentr = "INSERT INTO answerqustion (id,anser,qustionid,iansernumber) VALUES ($idanswer1,'$Answer1',$quizId2,$checkbox1);";
            } else if ($i == 2) {
                $addDataToStudentr = "INSERT INTO answerqustion (id,anser,qustionid,iansernumber) VALUES ($idanswer1,'$Answer2',$quizId2,$checkbox2);";
            } else if ($i == 3) {
                $addDataToStudentr = "INSERT INTO answerqustion (id,anser,qustionid,iansernumber) VALUES ($idanswer1,'$Answer3',$quizId2,$checkbox3);";
            } else if ($i == 4) {
                $addDataToStudentr = "INSERT INTO answerqustion (id,anser,qustionid,iansernumber) VALUES ($idanswer1,'$Answer4',$quizId2,$checkbox4);";
            }
            mysqli_query($connection, $addDataToStudentr);
        }
        header("Location:addQuestionForQuiz.php?courseId=$courseId");
    } else {
        echo "<span style='color: red'> please enter at least one answer</span>";
    }
}

if (isset($_POST['back'])) {
    header("Location:instructor.php?id=$instructorId");
}
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="stylesheet" href="../../style/formStyle.css">
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font: 14px sans-serif;
            max-width: max-content;
            margin: auto;
            padding: 100px;
        }

        .disclaimer {
            display: none;
        }

        .wrapper {
            width: 360px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <form action="" method="post">

        <h2>Add Question</h2>
        <div class="form-group">
            <label>Question</label>
            <input type="text" name="question" class="form-control" required>

        </div>
        <div class="form-group">
            <label>Answer 1</label>
            <input type="text" name="Answer1" class="form-control" required>
            is true<input type="checkbox" name="checkbox1">
            <!--        <span>--><?php //echo empty($Answer1_err) ? " " : $Answer1_err; 
                                    ?>
            <!--</span>-->
        </div>
        <div class="form-group">
            <label>Answer 2</label>
            <input type="text" name="Answer2" class="form-control" required>
            is true<input type="checkbox" name="checkbox2">
            <!--        <span>--><?php //echo empty($Answer2_err) ? " " : $Answer2_err; 
                                    ?>
            <!--</span>-->
        </div>
        <div class="form-group">
            <label>Answer 3</label>
            <input type="text" name="Answer3" class="form-control" required>
            is true<input type="checkbox" name="checkbox3">
            <!--        <span>--><?php //echo empty($Answer3_err) ? " " : $Answer3_err; 
                                    ?>
            <!--</span>-->
        </div>
        <div class="form-group">
            <label>Answer 4</label>
            <input type="text" name="Answer4" class="form-control" required>
            is true<input type="checkbox" name="checkbox4">
            <!--        <span>--><?php //echo empty($Answer4_err) ? " " : $Answer3_err; 
                                    ?>
            <!--</span>-->
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Add">
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="back" value="back">
        </div>
    </form>
</body>

</html>
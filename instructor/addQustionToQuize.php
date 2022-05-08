<?php
include_once("../modle/DB.php");
$quizeId = $_GET['id'];
session_start();
if (isset($_POST['submit'])) {
    if (!empty($_POST['Qustion']) && !empty($_POST['Answer1']) && !empty($_POST['Answer2']) && !empty($_POST['Answer3']) && !empty($_POST['Answer4']) && (!empty($_POST['checkbox1']) || !empty($_POST['checkbox2']) || !empty($_POST['checkbox3']) || !empty($_POST['checkbox4']))) {
        $Qustion = input($_POST['Qustion']);
        $Answer1 = input($_POST['Answer1']);
        $Answer2 = input($_POST['Answer2']);
        $Answer3 = input($_POST['Answer3']);
        $Answer4 = input($_POST['Answer4']);
        $checkbox1 = empty($_POST['checkbox1']) ? 0 : 1;
        $checkbox2 = empty($_POST['checkbox2']) ? 0 : 1;
        $checkbox3 = empty($_POST['checkbox3']) ? 0 : 1;
        $checkbox4 = empty($_POST['checkbox4']) ? 0 : 1;
        echo "
        <script type='text/javascript'>
        alert('Add Successfully');
        </script> ";
        header("Location:insertQuestionForQuiz.php?quizId=$quizeId &question=$Qustion&ans1=$Answer1&ans2=$Answer2&ans3=$Answer3&ans4=$Answer4&check1=$checkbox1&check2=$checkbox2&check3=$checkbox3&check4=$checkbox4");

        exit();
    } else {
        $Qustion_err = empty($_POST['Qustion']) ? 'Not entering the Qustion' : "";
        $valueQustion = empty($_POST['Qustion']) ? '' : $_POST['Qustion'];
        $Answer1_err = empty($_POST['Answer1']) ? "Not entering the Answer1" : "";
        $valueAnswer1 = empty($_POST['Answer1']) ? '' : $_POST['Answer1'];
        $Answer2_err = empty($_POST['Answer2']) ? "Not entering the Answer2" : "";
        $valueAnswer2 = empty($_POST['Answer2']) ? '' : $_POST['Answer2'];
        $Answer3_err = empty($_POST['Answer3']) ? "Not entering the Answer3" : "";
        $valueAnswer3 = empty($_POST['Answer3']) ? '' : $_POST['Answer3'];
        $Answer4_err = empty($_POST['Answer4']) ? "Not entering the Answer4" : "";
        $valueAnswer4 = empty($_POST['Answer4']) ? '' : $_POST['Answer4'];
        if (empty($_POST['checkbox1']) && empty($_POST['checkbox2']) && empty($_POST['checkbox3']) && empty($_POST['checkbox4'])) {
            $checkbox_err = "not selected anser is true";
        } else {
            $checkbox_err = "";
        }
    }
}
// back to bage showQuestions.php
if (isset($_POST['Back'])) {
    header("location:showQustioninQuize.php?id=$quizeId");
}
//formate data insert 
function input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    return $data;
}
if (isset($_POST['reset'])) {
    $Qustion_err = "";
    $valueQustion = '';
    $Answer1_err = "";
    $valueAnswer1 = "";
    $Answer2_err = "";
    $valueAnswer2 = "";
    $Answer3_err = "";
    $valueAnswer3 = "";
    $Answer4_err = "";
    $valueAnswer4 = "";
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

        span {
            color: red;
            size: 3px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Add Qustion in Quize</h2>
        <form action="" method="post">
            <div class="form-group">
                <label>Qustion </label>
                <input type="text" name="Qustion" class="form-control" value="<?php echo empty($valueQustion) ? '' : $valueQustion; ?>">
                <span><?php echo empty($Qustion_err) ? " " : $Qustion_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 1</label>
                <input type="text" name="Answer1" class="form-control" value="<?php echo empty($valueAnswer1) ? '' : $valueAnswer1; ?>">
                <span><?php echo empty($Answer1_err) ? " " : $Answer1_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 2</label>
                <input type="text" name="Answer2" class="form-control" value="<?php echo empty($valueAnswer2) ? '' : $valueAnswer2; ?>">
                <span><?php echo empty($Answer2_err) ? " " : $Answer2_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 3</label>
                <input type="text" name="Answer3" class="form-control" value="<?php echo empty($valueAnswer3) ? '' : $valueAnswer3; ?>">
                <span><?php echo empty($Answer3_err) ? " " : $Answer3_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 4</label>
                <input type="text" name="Answer4" class="form-control" value="<?php echo empty($valueAnswer4) ? '' : $valueAnswer4; ?>">
                <span><?php echo empty($Answer4_err) ? " " : $Answer4_err; ?></span>
            </div>
            <div class="form-group">
                Anser is true :
                <br>
                <br>
                <input id="Answer1" type="checkbox" name="checkbox1">
                <label for="Answer1">Answer 1</label>
                <input id="Answer2" type="checkbox" name="checkbox2">
                <label for="Answer2">Answer 2</label>
                <input id="Answer3" type="checkbox" name="checkbox3">
                <label for="Answer3">Answer 3</label>
                <input id="Answer4" type="checkbox" name="checkbox4">
                <label for="Answer4">Answer 4</label>
                <span><?php echo empty($checkbox_err) ? " " : $checkbox_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name='submit' value="  Add  ">
                <input type="submit" name="reset" class="btn btn-secondary ml-2" value="Reset">
                <input type="submit" class="btn btn-secondary ml-2" name='Back' value="Back">
            </div>

        </form>
    </div>

</body>

</html>
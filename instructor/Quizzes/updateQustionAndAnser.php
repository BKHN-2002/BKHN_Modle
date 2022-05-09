<?php
include_once("../../modle/DB.php");
$idQuze = $_GET['idQuize'];
$idQustion = $_GET['id'];
//select answer Qustion
//SELECT `id`, `anser`, `qustionid`, `iansernumber` FROM `answerqustion` WHERE 1
$selectIdQuize = "SELECT id as idanswer,qustionid as qustionid, anser as anser FROM answerqustion WHERE qustionid=$idQustion";
$data = mysqli_query($connection, $selectIdQuize);
//select Qustion
//SELECT `id`, `qustion`, `quizId` FROM `selectquise` WHERE 1
$selectIdQuize1 = "SELECT qustion FROM selectquise WHERE id=$idQustion";
$data1 = mysqli_query($connection, $selectIdQuize1);
$result = mysqli_fetch_all($data1);
$valueQustion = $result[0][0];
$counter = 1;
$idanswer1 = 0;
$idanswer2 = 0;
$idanswer3 = 0;
$idanswer4 = 0;
//select ansewer and file input
while ($res = mysqli_fetch_assoc($data)) {
    if ($res != 0) {
        if ($counter == 1 && $res['qustionid'] == $idQustion) {
            $idanswer1 = $res['idanswer'];
            $valueAnswer1 = $res['anser'];
            $counter++;
        } else if ($counter == 2 && $res['qustionid'] == $idQustion) {
            $idanswer2 = $res['idanswer'];
            $valueAnswer2 = $res['anser'];
            $counter++;
        } else if ($counter == 3 && $res['qustionid'] == $idQustion) {
            $idanswer3 = $res['idanswer'];
            $valueAnswer3 = $res['anser'];
            $counter++;
        } else if ($counter == 4 && $res['qustionid'] == $idQustion) {
            $idanswer4 = $res['idanswer'];
            $valueAnswer4 = $res['anser'];
            $counter++;
        }
    }
}

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
        //apdate qustion
        $updateQustion = "UPDATE selectquise SET qustion='$Qustion' WHERE id=$idQustion;";
        mysqli_query($connection, $updateQustion);
        //update answer
        $Updateanswer = "UPDATE answerqustion SET anser='$Answer1',iansernumber=$checkbox1 WHERE id=$idanswer1;";
        $Updateanswer .= "UPDATE answerqustion SET anser='$Answer2',iansernumber=$checkbox2 WHERE id=$idanswer2;";
        $Updateanswer .= "UPDATE answerqustion SET anser='$Answer3',iansernumber=$checkbox3 WHERE id=$idanswer3;";
        $Updateanswer .= "UPDATE answerqustion SET anser='$Answer4',iansernumber=$checkbox4 WHERE id=$idanswer4;";
        mysqli_multi_query($connection, $Updateanswer);
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
if (isset($_POST['Back'])) {
    header("location:showQustioninQuize.php?id=$idQuze");
}
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
        <h2>Update Qustion </h2>
        <form action="" method="post">
            <div class="form-group">
                <label>Qustion </label>
                <input type="text" name="Qustion" class="form-control" value="<?php echo empty($valueQustion) ? '' : $valueQustion; ?>">
                <span><?php echo empty($Qustion_err) ? " " : $Qustion_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 1</label>
                <input type="text" name="Answer1" class="form-control" value="<?php echo empty($valueAnswer1) ? '1' : $valueAnswer1; ?>">
                <span><?php echo empty($Answer1_err) ? " " : $Answer1_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 2</label>
                <input type="text" name="Answer2" class="form-control" value="<?php echo empty($valueAnswer2) ? '2' : $valueAnswer2; ?>">
                <span><?php echo empty($Answer2_err) ? " " : $Answer2_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 3</label>
                <input type="text" name="Answer3" class="form-control" value="<?php echo empty($valueAnswer3) ? '3' : $valueAnswer3; ?>">
                <span><?php echo empty($Answer3_err) ? " " : $Answer3_err; ?></span>
            </div>
            <div class="form-group">
                <label>Answer 4</label>
                <input type="text" name="Answer4" class="form-control" value="<?php echo empty($valueAnswer4) ? '4' : $valueAnswer4; ?>">
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
                <input type="submit" class="btn btn-primary" name='submit' value="  Update  ">
                <input type="submit" name="reset" class="btn btn-secondary ml-2" value="Reset">
                <input type="submit" class="btn btn-secondary ml-2" name='Back' value="Back">
            </div>

        </form>
    </div>

</body>

</html>
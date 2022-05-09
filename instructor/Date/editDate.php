<?php
include_once("../../modle/DB.php");
session_start();
if (isset($_GET['submit'])) {
    if (isset($_GET['quizId'])) {
        $query = mysqli_query($connection, "update quizzes set startTime='" . $_GET['timeStart'] . "' ,endTime='" . $_GET['timeEnd'] . "' where id=" . $_GET['quizId']);
    } else if (isset($_GET['assignmentId'])) {
        $query = mysqli_query($connection, "update assignment set startTime='" . $_GET['timeStart'] . "' ,endTime='" . $_GET['timeEnd'] . "' where id=" . $_GET['assignmentId']);
    }
    header("LOCATION:../instructor.php");
}
?>
<html>
<title>Edit Date</title>

<head>
    <link rel="stylesheet" href="../../style/formStyle.css">
</head>
<style>
    .parent {
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<body>
    <div class="parent">
        <div class="q">
            <form>
                <h1 style="text-align: center">Edit Date</h1>
                <div style="width: 300px;text-align: center; margin: auto" class="form-group">
                    <label>
                        <h3>Add Start Time of Quize</h3>
                    </label>
                    <input type="datetime-local" id="start" name="timeStart" style="width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;">
                </div>
                <div style="width: 300px;text-align: center; margin: auto" class="form-group">
                    <label>
                        <h3>Add End Time of Quize</h3>
                    </label>
                    <input type="datetime-local" id="start" name="timeEnd" style="width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;">
                </div>
                <input type="hidden" name="<?php echo isset($_GET['quizId']) ? 'quizId' : 'assignmentId' ?>" value="<?php echo isset($_GET['quizId']) ? $_GET['quizId'] : $_GET['assignmentId'] ?>">
                <input type="submit" style="      background-color: #9933ff;
" name="submit">
            </form>

        </div>
    </div>


</body>

</html>
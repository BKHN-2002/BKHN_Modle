<?php
session_start();
include_once("../../modle/DB.php");
$idstudent = $_SESSION['username'];
$quizeId = $_GET['quizId'];

//$con = mysqli_connect("localhost", "root", "", "moodledb");
//if (!$con) {
//    die("Erore Database connection " . mysqli_connect_error($con));
//} else {

$query3 = "SELECT startTime,endTime from quizzes where id=$quizeId";
$dat3 = mysqli_query($connection, $query3);
$res3 = mysqli_fetch_all($dat3);
$startTimeOfQuiz = $res3[0][0];
$endTimeOfQuiz = $res3[0][1];

$query = "SELECT se.qustion,an.anser,an.iansernumber,se.id FROM selectquise AS se JOIN answerqustion an on se.id = an.qustionid WHERE se.quizId = $quizeId";
//    $countOfQuestion = "SELECT * FROM `selectquise`";
$dat = mysqli_query($connection, $query);
$res = mysqli_fetch_all($dat);
$count = mysqli_query($connection, "SELECT * FROM `selectquise` where quizId=$quizeId")->num_rows;
//    $count=mysqli_num_rows($countOfQuestion);
//}
if (isset($_POST['submit'])) {
    $grade = 0;
    //    $count = 0;

    foreach ($_POST as $val) {
        if ($val != 'submit') {
            $grade += $val;
            //            $count++;
        }
    }

    $grade = ($grade / $count);
    $idstudent = $_SESSION['username'];

    //    echo 'count' . $count;
    //    echo "<br>";
    //    echo 'grade' . $grade;
    $addDataToGradd = "INSERT INTO quizzesgrades (`quizId`, `studentId`, `grade`) VALUES ('$quizeId','$idstudent','$grade')";
    mysqli_query($connection, $addDataToGradd);
    header("Location:Student.php?id=$idstudent");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <style>
        .disclaimer{
            display : none;
        }
        *{
            box-sizing: border-box;
            /* margin: 0%;
            padding: 0%; */
        }
        #demo {
            position: fixed;
            top: 8px;
            right: 16px;
            font-size: 18px;
            background-color: blue;
            font-weight: bold;
            color: white;
            border-radius: 20px;
            padding: 20px;
            display: flex;
        }

        .submit {
            color: white;
            background-color: blueviolet;
            border-radius: 8px;
            border: 3px solid black;
            /* box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); */
            padding: 10px 20px 10px 20px;
            position: absolute;
        }



        label {
            /* background-color: #eee; */
        }
        .demo{
            margin: auto;
            width: 50%;
            border: 3px solid black;
            padding: 10px;
            text-align: center;
            font-size: 35px;
        }
        table {
            width: 100%;
            margin: 0px;
            z-index: 1000;
        }

        th,
        td {
            padding: 15px;
            text-align: left;
        }

        th,
        td {
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background-color: #c5c5f6;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        th {
            background-color: #9933ff;
            color: white;
        }
    </style>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quize <?php echo $quizeId ; ?></title>
    <link rel="stylesheet" href="../../style/quizeStyle.css">
</head>

<body>
<p id="demo"></p>
<?php
$query = mysqli_query($connection, "select * from quizzesgrades 
                where quizId=" . $quizeId . " and studentId=" . $_SESSION['username']);
date_default_timezone_set("Asia/Jerusalem");
if ($startTimeOfQuiz < date("Y-m-d H:i:s")) {
    if (mysqli_num_rows($query) == 0) {
        echo "<form action='' method='post'>";
        echo "<div class='form-group'>";
        $counter = 1;
        $cont = 0;
        foreach ($res as $key => $value) {
            echo "<table class='question-container'>";
            if ($cont != $value[3]) {
                echo "<tr>";
                $cont = $value[3];
                echo "<th>";
                echo $counter++ . ' - ' . "<label  style='font-size: 18px;margin-bottom: 20px;'>$value[0].</label>";
                echo "</th>";
                echo "<br>";
                echo "<br>";
                $idQustion = $value[0];
                echo "</tr>";

            }
            echo "<tr>";

            echo "<td>";
            echo "<label style='font-size: 14px;' class='container'>$value[1]";
            echo "<input type='radio' value='$value[2]' name='$value[3]' value='student'>";
            echo "<span class='checkmark'></span>";
            echo "</label>";
            echo "<br>";
            echo "</div>";
            echo "</td>";
            echo "<tr>";
        }
        echo "</table>";
        echo "<input type='submit' class='submit' value='submit' name='submit'>";
        ?>

        <script>
            var countDownDate = new Date("<?php echo $endTimeOfQuiz ?>").getTime();
            var studentId = <?php echo $idstudent; ?>;
            var quizId = <?php echo $quizeId; ?>;
            var x = setInterval(function() {

                var now = new Date().getTime();

                var distance = countDownDate - now;

                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                document.getElementById("demo").innerHTML = hours + "h: " +
                    minutes + "m: " + seconds + "s ";

                if (distance < 0) {
                    location.replace("insertToDbWhenTmeEnd.php?quizId=" + quizId+"&id="+studentId);
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";

                }
            }, 1000);
        </script>

        <?php
    } else {
        echo "<div class='demo'>";
        echo "<p  style='color:red'> sorry you already solve this quiz.</p>";
        echo "</div>";
    }
} else {
    $timestamp = strtotime($startTimeOfQuiz);

    $day = date('l', $timestamp);
    echo "<div class='demo'>";
    echo "<p style='color:red'> sorry this quiz open in  $day  $startTimeOfQuiz .</p>";
    echo "</div>";
}


?>


</body>

</html>
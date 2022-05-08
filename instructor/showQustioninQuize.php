<?php
session_start();
$idQuize = $_GET['id'];
include_once("../modle/DB.php");
$selectqustion = "SELECT id,qustion FROM selectquise   WHERE quizId =$idQuize";
$selectqustiondata = mysqli_query($connection, $selectqustion);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../s.css">
  <style>
    /* Style the navigation bar */
    .navbar {
      width: 100%;
      background-color: #555;
      overflow: auto;
    }

    /* Navbar links */
    .navbar a {
      float: left;
      text-align: center;
      padding: 12px;
      color: white;
      text-decoration: none;
      font-size: 17px;
    }

    .navbar a:hover {
      background-color: #000;
    }

    .active {
      background-color: #04AA6D;
    }

    @media screen and (max-width: 100%) {
      .navbar a {
        float: none;
        display: block;
      }
    }

    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
      padding: 8px;
      height: auto;
    }

    #customers tr:nth-child(even) {
      background-color: #f2f2f2;
    }

    #customers tr:hover {
      background-color: #ddd;
    }

    #customers th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #04AA6D;
      color: white;
    }
  </style>
</head>

<body>


  <div class="navbar">
    <a class="active" href="instructor.php?id=<?php echo $_SESSION['username'] ?>"><i class="fa fa-fw fa-home"></i> Home</a>
    <a href='addQustionToQuize.php?id=<?php echo $idQuize; ?>'><i class=""></i> Add Qustion to Quize</a>
    <a href='showCourses.php'><i class=""></i> Back</a>
  </div>
  <h1>A Qustion Of Quize</h1>
  <table id="customers">
    <tr>
      <th>Qustion</th>
      <th>Answer1</th>
      <th>Answer2</th>
      <th>Answer3</th>
      <th>Answer4</th>
      <th>Update</th>
      <th>Delete</th>
    </tr>
    <?php

    while ($resultselectQustion = mysqli_fetch_assoc($selectqustiondata)) {
      if ($resultselectQustion != 0) {
        echo "<tr>";
        $Qustion = $resultselectQustion['qustion'];
        $QustionId = $resultselectQustion['id'];
        echo "<td>$Qustion</td>";
        $conter = 0;
        $selectanswer = "SELECT  anser FROM answerqustion  WHERE qustionid = $QustionId";
        // echo $selectanswer;
        $selectanswerdata = mysqli_query($connection, $selectanswer);

        while ($resultselectanswerdata = mysqli_fetch_assoc($selectanswerdata)) {
          if ($resultselectanswerdata != 0) {
            $answer = $resultselectanswerdata['anser'];
            echo "<td>$answer</td>";
            $conter++;
          }
        }

        if ($conter < 4) {
          for ($i = $conter; $i < 4; $i++) {
            echo "<td>  </td>";
          }
        }
        $conter = 0;
        echo "<td><a href='updateQustionAndAnser.php?id=$QustionId&idQuize=$idQuize'>Update</a></td>";
        echo "<td><a href='deleteQustionAndAnswer.php?id=$QustionId&idQuize=$idQuize'>Delete</a></td>";
        echo "</tr>";
      }
    }


    ?>
  </table>
</body>

</html>
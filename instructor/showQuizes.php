<?php
$id = $_GET['courseId'];
include_once("../modle/DB.php");
$sql = "SELECT name,id from  quizzes where courseId=$id";
// $query = "SELECT q.id as quisId , q.name nameofQuis FROM  quizzes q join course c on c.id=q.courseId  WHERE c.id=$id;";
$dat = mysqli_query($connection, $sql);

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
    #customers {
      font-family: Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    #customers td,
    #customers th {
      border: 1px solid #ddd;
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
      padding: 14px 25px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      width: 100%;

    }

    body {

      overflow: hidden;
    }

    .alink {
      text-decoration: none;
      color: black;
      padding: 14px 25px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
      width: 100%;
    }

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
  </style>
</head>

<body>
  <h1>A Quizes Table</h1>
  <table id="customers">
    <tr>
      <th>Name of Quizes</th>
    </tr>
    <?php
    while ($data = mysqli_fetch_assoc($dat)) {
      if ($data != 0) {
        echo "<tr>";
        echo "<td>";
        $id = $data['id'];
        $nameOfQuiz = $data['name'];
        echo "<a class='alink' href='showQustioninQuize.php?id=$id'>$nameOfQuiz</a>";
        echo "</td>";
        echo "</tr>";
      }
    }

    ?>

  </table>

  <a class='alink' style="background-color: red; width: 100%;" href='showCourses.php'>Back</a>

</body>

</html>
<?php
session_start();
$instructorId = $_SESSION['username'];
include_once("../modle/DB.php");
$query = "SELECT courseId  FROM instructor_course where instructorID =$instructorId";
$dat = mysqli_query($connection, $query);
// $res = $dat->fetch_assoc();

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
  </style>
</head>

<body>


  <div class="navbar">
    <a class="active" href="../instructor/instructor.php?id=<?php echo $instructorId ?>>"><i class="fa fa-fw fa-home"></i>Home</a>
  </div>
  <h1>A Course Table</h1>
  <table id="customers">
    <tr>
      <th>Name of Course</th>
    </tr>
    <?php
    while ($row = $dat->fetch_assoc()) {
      $courseId = $row['courseId'];
      $sql = "SELECT name from courses where id=" . $row['courseId'];
      $nameCourse = mysqli_query($connection, $sql)->fetch_assoc()['name'];
      echo "<tr>";
      echo "<td>";
      echo "<a class='alink' href='showQuizes.php?courseId=$courseId'>$nameCourse</a>";
      echo "</td>";
      echo "</tr>";
    }

    ?>
  </table>
</body>

</html>
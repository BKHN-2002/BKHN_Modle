<?php
session_start();
require_once "../modle/DB.php";
$echoCourseExist = " ";
include("../auth/auth.php");
if (isset($_SESSION['username'])) {
    echo "ss";
} else {
    echo "ss";
}
if (isset($_POST["submit"]) && isAdmin($connection)) {
    $courseId = validator($_POST["courseId"]);
    $courseName = validator($_POST["courseName"]);
    $numOfHours = validator($_POST["numOfHours"]);
    $courseExist = false;


    if (!empty($courseName) && !empty($courseId) && !empty($numOfHours)) {
        $allCourse = "SELECT `id` FROM `courses`";
        $result = mysqli_query($connection, $allCourse);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($courseId == $row['id']) {
                    $echoCourseExist = "this course is already exist ..";
                    $courseExist = true;
                    break;
                }
            }
        } else
            $echoCourseExist = "There Is No Data To Show";


        if (!$courseExist) {
            $sql = "INSERT INTO `courses`(`id`, `name`, `numHour`) VALUES ( $courseId ,'$courseName',$numOfHours)";
            if (mysqli_query($connection, $sql)) {
            } else
                echo "Error " . $sql . mysqli_error($conn);
        }
    } else {
        echo "enter a correct data ... ";
    }
}

function validator($str)
{
    $str = trim($str);
    //to remove the over spaces
    $str = htmlspecialchars($str);
    //to make server deal with html tage as string 
    $str = stripslashes($str);
    //to validate the slashes
    return $str;
    //return the data ( that passed the fauntion ) after validate it  
}
?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add A New Course</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href='css/css/plugins/fontawesome-free/css/all.min.css'>
    <link rel="stylesheet" href='css/css/dist/css/adminlte.min.css'>
    <link rel="stylesheet" href='cms/css/plugins/toastr/toastr.min.css'>
    <style>
        .label {
            padding: 27px;
            text-transform: capitalize;
            font-size: 26px;
        }

        .sbmit {
            font-size: 20px;
            font-weight: 600;
            text-transform: uppercase;
            color: white;
            background-color: #007bff;
            margin: 43px 20px;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
        }

        .input {
            width: 27%;
            border: none;
            margin: 0px 50px 20px;
            height: 42px;
        }

        .input::placeholder {
            padding: 0 10px;
        }

        .input:focus {
            outline: none;
        }

        .state {
            font-size: 15px;
            padding: 10px 90px 0;
            text-transform: capitalize;
            font-weight: 600;
            color: red;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <!-- khaled ==> three line bar -->
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="home.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../logIn_register/logout.php" class="nav-link">LogOut</a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="" class="brand-link" style="text-align: center;">
                <span class="brand-text font-weight-light "> Admin DashBorad </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-address-card"></i>
                                <p>
                                    Student Actions
                                </p>
                            </a>
                        <li class="nav-item">
                            <a href="addStdToCourseFirstPart.php" class="nav-link" style=" padding-left : 22px ;">
                                <p style="font-weight: 400; font-size:13px ; ">
                                    Add student To Course
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="deleteStdFromCourseFirstPart.php" class="nav-link" style=" padding-left : 22px ;">
                                <p style="font-weight: 400; font-size:13px ; ">
                                    Delete student From Course
                                </p>
                            </a>
                        </li>
                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-address-book"></i>
                                <p>
                                    Instructor Actions
                                </p>
                            </a>
                        <li class="nav-item">
                            <a href="addInstructorToCourse.php" class="nav-link" style=" padding-left : 22px ;">
                                <p style="font-weight: 400; font-size:13px ; ">
                                    Add Instrcutor To Course
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="deleteInstructorFromCourseFirstPart.php" class="nav-link" style=" padding-left : 22px ;">
                                <p style="font-weight: 400; font-size:13px ; ">
                                    Delete Instrcutor From Course
                                </p>
                            </a>
                        </li>
                        </li>
                    </ul>

                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link active">
                                <i class="nav-icon fas fa-book-open"></i>
                                <p>
                                    Course Actions
                                </p>
                            </a>
                        <li class="nav-item">
                            <a href="addCourse.php" class="nav-link" style=" padding-left : 22px ;">
                                <p style="font-weight: 400; font-size:13px ; ">
                                    Add Course
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="deleteCourse.php" class="nav-link" style=" padding-left : 22px ;">
                                <p style="font-weight: 400; font-size:13px ; ">
                                    Delete Course
                                </p>
                            </a>
                        </li>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <div class="content-wrapper">
            <div class="content-header">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="courseId-container">
                        <label class="label" for="">Course ID : </label>
                        <div>
                            <input class="input" type="number" name="courseId" placeholder="Enter Course ID ">
                        </div>
                    </div>
                    <div class="courseName-container">
                        <label class="label" for="">course Name : </label>
                        <div>
                            <input class="input" type="text" name="courseName" placeholder="Enter Course Name ">
                        </div>
                    </div>
                    <div class="numOfHours-container">
                        <label class="label" for="">Number Of Hours : </label>
                        <div>
                            <input class="input" type="number" name="numOfHours" placeholder="Enter Number Of Hours For This Course ">
                        </div>
                    </div>
                    <h4 class="state">
                        <?php echo $echoCourseExist; ?>
                    </h4>
                    <input class="sbmit" type="submit" name="submit" value="add">
                </form>
            </div>
        </div>

        <aside class="control-sidebar control-sidebar-dark">
            <div class="p-3">
                <h5>Title</h5>
                <p>Sidebar content</p>
            </div>
        </aside>

        {{-- <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Anything you want
        </div>
        <strong>Copyright &copy; 2014-2021</strong>
    </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src='css/plugins/jquery/jquery.min.js'></script>
<!-- Bootstrap 4 -->
<script src='css/plugins/bootstrap/js/bootstrap.bundle.min.js'></script>
<!-- AdminLTE App -->
<script src='css/dist/js/adminlte.min.js'></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src='cms/plugins/toastr/toastr.min.js'></script>
</body>

</html>
<?php
session_start();

if (isset($_SESSION['adminLogin'])) {
    require_once("../modle/DB.php");

    // getting number of students 
    $stdSql = "SELECT DISTINCT `id` FROM `student`";
    $result = mysqli_query($connection, $stdSql);
    if (mysqli_num_rows($result) > 0) {
        $numOfStd = mysqli_num_rows($result);
    } else {
        $numOfStd = 0;
    }

    // getting number of students wha has a course 
    $stdWhoHasCourseSql = "SELECT DISTINCT `studentId`  FROM `student_course`";
    $resultOfstdWhoHasCourse = mysqli_query($connection, $stdWhoHasCourseSql);
    if (mysqli_num_rows($resultOfstdWhoHasCourse) > 0) {
        $numOfStdWhoHasCourse = mysqli_num_rows($resultOfstdWhoHasCourse);
    } else {
        $numOfStdWhoHasCourse = 0;
    }

    // getting number of instructor 
    $inatructorSql = "SELECT `id`  FROM `instructor`";
    $resultOfInatructorSql = mysqli_query($connection, $inatructorSql);
    if (mysqli_num_rows($resultOfInatructorSql) > 0) {
        $numOfInstructor = mysqli_num_rows($resultOfInatructorSql);
    } else {
        $numOfInstructor = 0;
    }
    // getting number of Student Who Has Cours
    $instructorWhoTeachCourseSql = "SELECT DISTINCT `instructorID` FROM `instructor_course`";
    $resultOfinstructorWhoTeachCourseSql = mysqli_query($connection, $instructorWhoTeachCourseSql);
    if (mysqli_num_rows($resultOfinstructorWhoTeachCourseSql) > 0) {
        $numOfInstructorWhoTeachACourse = mysqli_num_rows($resultOfinstructorWhoTeachCourseSql);
    } else {
        $numOfInstructorWhoTeachACourse = 0;
    }

    //getting number Of Courses
    $courseSql = "SELECT `id` FROM `courses`";
    $resultOfCourseSql = mysqli_query($connection, $courseSql);
    if (mysqli_num_rows($resultOfCourseSql) > 0) {
        $numOfCourse = mysqli_num_rows($resultOfCourseSql);
    } else {
        $numOfCourse = 0;
    }

    //getting number Of Courses that active 
    $courseThatActiveSql = "SELECT DISTINCT `courseId` FROM `instructor_course`";
    $resultOfCourseThatActiveSql = mysqli_query($connection, $courseThatActiveSql);
    if (mysqli_num_rows($resultOfCourseThatActiveSql) > 0) {
        $numOfCourseThatActive = mysqli_num_rows($resultOfCourseThatActiveSql);
    } else {
        $numOfCourseThatActive = 0;
    }
} else {
    header("Location:../admin/adminlogin.php");
}



?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href='css/css/plugins/fontawesome-free/css/all.min.css'>
    <link rel="stylesheet" href='css/css/dist/css/adminlte.min.css'>
    <link rel="stylesheet" href='cms/css/plugins/toastr/toastr.min.css'>

    <style>
        * {
            text-transform: capitalize;
        }

        .content-wrapper {
            display: flex;
            width: calc(100% - 250px);
            overflow: hidden;
        }

        .content-header {
            width: 100%;
            overflow: hidden;
        }

        .content-header h2 {
            font-weight: 800;
            font-size: 2rem;
            color: #007bff;
            padding: 20px;
        }

        .content-header .information-container {
            margin: 50px 20px;
            width: 100%;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            flex-direction: column;
        }

        .content-header .information-container h3 {
            color: #343a40;
            text-transform: uppercase;
            font-weight: 600;
            padding: 0 20px;
        }

        .content-header .information-container .infos {
            padding: 0px;
            margin: 50px 0px;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-evenly;
            align-items: center;
        }

        .content-header .information-container .box {
            margin: 30px 0px;
            padding: 10px 10px;
            background-color: #4c92dd;
            color: white;
            border-radius: 20px;
            width: 30%;
            display: flex;
            justify-content: space-evenly;
            align-items: flex-start;
            flex-direction: column;
        }

        .content-header .information-container .box h4 {
            font-weight: 700;
            color: black;
        }

        .content-header .information-container .box p {
            padding: 0 20px;
            font-weight: 700;
        }

        @media (max-width : 1517px) {
            .content-wrapper {
                margin-left: 250px;
            }

            .content-header .information-container .box {
                width: 45%;
            }
        }

        @media (max-width : 1141px) {
            .content-wrapper {
                margin-left: 250px;
            }

            .content-header .information-container .box {
                width: calc(100% - 259px);
            }
        }

        @media (max-width: 991.98px) {
            .content-wrapper {
                margin-left: 250px !important;
            }
        }

        @media (max-width: 739px) {
            .content-wrapper {
                width: 100%;
                margin-left: 0px !important;
            }

            .content-header {
                width: 100%;
            }
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
                                <i class="nav-icon  fas fa-book-open"></i>
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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <h2>Hello to admin dashborad </h2>
                <div class="information-container">
                    <h3>informations : </h3>
                    <div class="infos">
                        <div class="box">
                            <h4>Student Inforamtions : </h4>
                            <p>number of students : <?php echo $numOfStd ?> </p>
                            <p>number of student who has a courses : <?php echo $numOfStdWhoHasCourse ?> </p>
                        </div>
                        <div class="box">
                            <h4>Instructor Inforamtions : </h4>
                            <p>number of Instructors : <?php echo $numOfInstructor; ?> </p>
                            <p>number of instructor who teach a courses : <?php echo $numOfInstructorWhoTeachACourse; ?> </p>
                        </div>
                        <div class="box">
                            <h4>course Inforamtions : </h4>
                            <p>number of courses : <?php echo  $numOfCourse; ?> </p>
                            <p>number of courses that active : <?php echo  $numOfCourseThatActive; ?> </p>
                        </div>
                    </div>
                </div>
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
        </div>
        <strong>Copyright &copy;2022</strong>
    </footer>
</div>
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
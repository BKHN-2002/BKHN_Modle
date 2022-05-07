<?php

require_once "connect.php";
$echoCourseExist = " ";

if (isset($_POST["submit"])) {
    $instructorId = validator($_POST["instructorId"]);
    if (!empty($instructorId)) {
        header('Location:deleteInstructorFromCourseSecPart.php?instructorId=' . $instructorId);
    } else {
        $echoCourseExist = "please enter a instructor ..... ";
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

function InstructorFiller()
{
    $sql = "SELECT * from instructor  ";
    $result = mysqli_query($GLOBALS['conn'], $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $instructorId = $row['id'];
            $instructorName = $row['name'];
            echo "<option value='$instructorId'>$instructorId - $instructorName </option>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Remove Instructor From Course</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href='css/css/plugins/fontawesome-free/css/all.min.css'>
    <link rel="stylesheet" href='css/css/dist/css/adminlte.min.css'>
    <link rel="stylesheet" href='cms/css/plugins/toastr/toastr.min.css'>
    <style>
        .ct-find-service {
            background: #00719b;
            font-family: 'stenciletta-solid', sans-serif;
            padding: 20px 25px;
            margin-top: 50px;
            margin-bottom: 15px;
            margin-top: 0;
            padding-left: 25px;
            padding-right: 25px;
        }

        .ct-find-service h2 {
            color: #fff;
            font-size: 38px;
        }

        @media (min-width: 1200px) {
            .ct-find-service {
                padding: 20px 55px;
            }
        }

        .ct-select-group {
            height: 64px;
            margin-bottom: 15px;
            position: relative;
        }

        .ct-select-group .ct-select {
            width: 100%;
            height: 64px;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
            font-size: 22px;
            border: none;
            background: transparent;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            cursor: pointer;
            padding: 5px 15px;
        }

        .ct-select-group .ct-select option {
            font-size: 22px;
            background: #fff;
        }

        .ct-select-group:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            height: 64px;
            width: calc(100% - 64px);
            background: #fff;
            z-index: 0;
        }

        .ct-select-group:after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 64px;
            height: 64px;
            background-color: #007bff;
            background-image: url(https://raw.githubusercontent.com/solodev/styling-select-boxes/master/select1.png);
            background-position: center;
            background-repeat: no-repeat;
            z-index: 0;
        }

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
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <form action="" method="post">
                    <div class="instructorId-container">
                        <label for="" class="label">Instructor ID : </label>
                        <div class="ct-select-group ct-js-select-group">
                            <select class="ct-select ct-js-select" name="instructorId">
                                <option value=""></option>
                                <?php InstructorFiller(); ?>
                            </select>
                        </div>
                    </div>
                    <h4 class="state">
                        <?php echo $echoCourseExist; ?>
                    </h4>
                    <input class="sbmit" type="submit" name="submit" value="submit">
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
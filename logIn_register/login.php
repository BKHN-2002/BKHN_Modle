<?php
session_start();
include_once "../modle/DB.php";
if (isset($_SESSION['adminLogin'])) {
    header("Location:../admin/home.php");
} else {
}
if (isset($_SESSION['username'])) {
    $instructorId = $_SESSION['username'];
    if (substr($_SESSION['username'], 0, 1) == 2) {
        header("Location:../instructor/instructor.php");
    } elseif (substr($_SESSION['username'], 0, 1) == 1) {
        header("Location:../student/student.php");
    }
}
if (isset($_POST['submit'])) {
    $_SESSION['username'] = $_POST['username'];
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        $username = input($_POST['username']);
        $password = input($_POST['password']);
        if (substr($username, 0, 1) == 1) {
            $query = "SELECT id,pass FROM student";
            $dat = mysqli_query($connection, $query);
            $res = mysqli_fetch_all($dat);
            foreach ($res as $key => $value) {
                if ($value[0] == $username && $value[1] == $password) {
                    header("location:../student/Student.php");
                    exit();
                } else {
                    $password_err = "Error password";
                }
            }
        } else if (substr($username, 0, 1) == 2) {
            $query = "SELECT id,pass FROM instructor";
            $dat = mysqli_query($connection, $query);
            $res = mysqli_fetch_all($dat);
            foreach ($res as $key => $value) {
                if ($value[0] == $username && $value[1] == $password) {
                    header("location:../instructor/instructor.php");
                    exit();
                } else {
                    $password_err = "Error password";
                }
            }
        } else {
            $query = "SELECT * FROM `admins`";
            $dat = mysqli_query($connection, $query);
            $res = mysqli_fetch_all($dat);
            foreach ($res as $key => $value) {
                if ($value[0] == $username && $value[1] == $password) {
                    $_SESSION['adminLogin'] = 1;
                    header("location:../admin/home.php");
                    exit();
                } else {
                    $password_err = "Error password";
                }
            }
        }
    } else {
        if (empty($_POST['username']) && empty($_POST['password'])) {
            $username_err = "Not entering the name";
            $password_err = "Not entering the password";
        } else {
            if (empty($_POST['username'])) {
                $username_err = "Not entering the name";
            } else if (empty($_POST['password'])) {
                $password_err = "Not entering the password";
            }
        }
    }
    //    }
}
function input($data)
{
    $data = trim($data);
    $data = htmlspecialchars($data);
    $data = stripcslashes($data);
    return $data;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
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
    <h2>Login</h2>
    <p>Please fill in your credentials to login.</p>
    <form action="" method="post">
        <div class="form-group">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="">
            <span><?php echo empty($username_err) ? " " : $username_err; ?></span>
        </div>
        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password" class="form-control">
            <span><?php echo empty($password_err) ? " " : $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" name="submit" value="Login">
        </div>
        <!-- <p>Log sin as admin? <a href="../admin/adminlogin.php">login now</a>.</p> -->
        <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
    </form>
</div>
</body>

</html>
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
} else {
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
                    header("location:../student/student.php");
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

        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;

        }
        body{
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #161623;

        }
        body::before{
            content: '';
            position: absolute;
            top: 0;
            Left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(#2196f3, #e91e63);
            clip-path: circle(30% at right 70%);

        }
        body::after{
            content: '';
            position: absolute;
            top: 0;
            Left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(#2196f3, #e91e63);
            clip-path: circle(20% at 10% 10%);

        }
        .wrapper {
            padding: 40px;
            color: white;
            position: relative;
            width: 480px;
            height: 500px;
            box-shadow: 20px 20px 50px rgba(0, 0, 0,0.5);
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.1);
            justify-content: center;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            border-Left: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
        }


        span {
            color: red;
            size: 3px;
        }

        .h2, h2 {
            font-size: 2rem;
            margin-left: 43%;
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
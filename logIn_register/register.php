<?php
include_once "../modle/DB.php";
if (isset($_POST['submit'])) {
    //    $con = mysqli_connect("localhost","root","","moodledb");
    //    if(!$con){
    //        die("Erore Database connection ".mysqli_connect_error($con));
    //    }else{
    if (!empty($_POST['namestudent']) && !empty($_POST['password']) && !empty($_POST['phoneNumber']) && !empty($_POST['confirm_password'])) {
        if (input($_POST['password']) != input($_POST['confirm_password'])) {
            $confirm_password_err = "confirm password error";
        } else {
            if ($_POST['studentOrInstructor'] == "student") {
                $name = input($_POST['namestudent']);
                $phoneNumber = input($_POST['phoneNumber']);
                $password = input($_POST['password']);
                $Gender = $_POST['gender'];
                $query = "SELECT count(*) FROM student";
                $dat = mysqli_query($connection, $query);
                $res = mysqli_fetch_all($dat);
                 $id = '1' . date("Y") . ($res[0][0] + 1);
                $addDataToStudent = "INSERT INTO student (id,name,pass,phoneNumber,gender) VALUES ('$id','$name','$password','$phoneNumber','$Gender');";
                mysqli_query($connection, $addDataToStudent);
//                echo $addDataToStudent;
                header("location:information.php?id=" . $id);
            } else {
                $name = input($_POST['namestudent']);
                $phoneNumber = input($_POST['phoneNumber']);
                $password = input($_POST['password']);
                $Gender = $_POST['gender'];
                $query = "SELECT count(*) FROM instructor";
                $dat = mysqli_query($connection, $query);
                $res = mysqli_fetch_all($dat);
                $id = '2' . date("Y") . ($res[0][0] + 1);
                $addDataToStudent = "INSERT INTO instructor (id,name,pass,phoneNumber,gender) VALUES ($id,'$name','$password','$phoneNumber','$Gender');";
                mysqli_query($connection, $addDataToStudent);
                header("location:information.php?id=" . $id);
            }
        }
    } else {
        $username_err = "Not entering the name";
        $password_err = "Not entering the password";
        $phoneNumber_err = "Not entering the phoneNumber";
        $confirm_password_err = "Not entering the password confirm password";
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style/sign.css">
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
            padding: 10px 25px 0 ;
            color: white;
            position: relative;
            width: 480px;
            /*height: 700px;*/
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
        .form-group {
            margin-bottom: 10px;
        }
        label {
                padding: 0  0 0 10px ;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="" method="post">
            <div class="form-group">
                <label>name :</label>
                <input type="text" name="namestudent" class="form-control" value="">
                <span><?php echo empty($username_err) ? " " : $username_err; ?></span>
            </div>
            <div class="form-group">
                <label>phone Number : </label>
                <input type="text" name="phoneNumber" class="form-control" value="">
                <span><?php echo empty($phoneNumber_err) ? " " : $phoneNumber_err; ?></span>
            </div>
            <div class="form-group">
                <label>Password : </label>
                <input type="password" name="password" class="form-control" value="">
                <span><?php echo empty($password_err) ? " " : $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password : </label>
                <input type="password" name="confirm_password" class="form-control" value="">
                <span><?php echo empty($confirm_password_err) ? " " : $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <span style="font-size: 15px;color: #2196F3;">Gender :</span>
                <label style="display: inline;font-size: 15px;" class="container">Male
                    <input  type="radio" checked="checked" value="" name="gender" value="student">
                    <span class="checkmark"></span>
                </label>
                <label style="display: inline;font-size: 15px;" class="container">Fmale
                    <input type="radio" name="gender" value="instructor">
                    <span class="checkmark"></span>
                </label>
            </div>
            <br>
            <div class="form-group">
                <label style="display: inline;font-size: 15px;" class="container">Student
                    <input type="radio" checked="checked" value="student" name="studentOrInstructor" value="student">
                    <span class="checkmark"></span>
                </label>
                <label style="display: inline;font-size: 15px;" class="container">Instructor
                    <input type="radio" name="studentOrInstructor" value="instructor">
                    <span class="checkmark"></span>
                </label>
            </div>
            <br>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name='submit' value="Submit" style="    background-color: #e91e63; border: none">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>

        </form>
    </div>
</body>

</html>
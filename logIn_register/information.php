<?php
session_start();
include_once "../modle/DB.php";
$id = $_GET['id'];
$path = substr($id,0,1)==1?'../student/Student.php':'../instructor/instructor.php';
if(substr($id,0,1)==1){
    $addDataToStudent = "SELECT * from student where id=".$id;
//    echo $addDataToStudent;
    $data=mysqli_query($connection,$addDataToStudent);
    $res = mysqli_fetch_all($data);
    $name = $res[0][1];
    $id = $res[0][0];
}else{
    $addDataToStudent = "SELECT * from instructor where id=".$id;
    $data=mysqli_query($connection,$addDataToStudent);
    $res = mysqli_fetch_all($data);
    $name = $res[0][1];
    $id = $res[0][0];
}

//        }
?>
<!DOCTYPE html>
<html>
<title>Informaion</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<body>

<div class="w3-container" style="margin-top: 100px;margin-left: 500px;">
    <div class="w3-card-4 w3-dark-grey" style="width:30%">
        <div class="w3-container w3-center">
            <h3><?php echo "Welcome ".$name;?></h3>
            <img src="../image/person.png" alt="Avatar" style="width:80%">
            <h5><?php echo "user name : ".$id;?></h5>
            <div class="w3-section">
                <?php
                if ( substr($id,0,1)==1) {
                    // echo substr($id,0,1)==1;
                    $path="../student/student.php";
                    $_SESSION['username']=$id;
                }else{
                    $path="../instructor/instructor.php";
                    // echo $path;
                    $_SESSION['username']=$id;
                    // echo $_SESSION['username'];

                }
                // echo $path;
                ?>
                <button class="w3-button btton1 w3-green" ><a name="send" style="text-decoration: none; padding:20px" href="<?php echo $path; ?>">Accept</a></button>
            </div>
        </div>
    </div>
</div>

</body>
</html>
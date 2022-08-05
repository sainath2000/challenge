<?php
session_start();
include_once 'dbconnection.php';
$email=$_SESSION['to_add'];
$vcode=(string)$_SESSION['randomCode'];
$vcodeError="";

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body style="margin: 0px;">

  <?php

    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['verify_button'])){
      $code=$_POST['code'];
      if($code===$vcode){
            $insertQuery = "INSERT INTO users (email,status) VALUES (?,?)";
            $result = mysqli_prepare($conn,$insertQuery);
            $status = "subscribed";
            mysqli_stmt_bind_param($result,'ss',$email,$status);
            if (mysqli_stmt_execute($result)) {
                // session_destroy();
                echo "<script>alert('Subscribed to XKCD successfully  ');";
                echo "window.close();";
                echo "window.location.replace('https://srxkcd.online/index.php'); </script>";
                
                } else {
                echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
                }

      }else{
        $vcodeError=" Incorrect verification code";
      }
      
    }
  ?>
  
    <div style="background-color: rgb(9, 38, 59);height:80px;text-align: center;border:1px solid rgb(9, 38, 59);padding:0;">
      <div><img style="color:white;" src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/image.png" alt="" width="100" height="80" ></div>
    </div>
    <div style="text-align:center;width: 450px;margin:50px auto;border: 1px solid black;border-radius: 5px;padding: 10px 5px 20px 5px;">
      <!-- <img src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/logo.png" height="100" width="100" > -->
      <p style="font-weight: bold;font-family: Arial, Helvetica, sans-serif;font-size:18px;">Email verification</p>
      <p style="font-size: 14px;margin:10px 0 30px">Email with verification code was sent. Enter code below to verify your email.</p>
      <!-- <a style="padding: 5px 10px;background-color: #0d6efd;border: none;color: white;border-radius: 5px;font-weight: bold;letter-spacing: 0.5px;cursor: pointer;text-decoration:none;margin-top:15px;" href="https://srxkcd.online//insert.php" >Subscribe</a> -->
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label style="margin:0 10px 0 0;">Email</label><input style="padding: 7px;width: 300px;margin:10px;letter-spacing:0.75px;" type="text" name="email" value="<?php echo $email; ?>" disabled><br>
        <label style="margin:0 10px 0 0;">Code</label><input style="outline:none;padding: 7px;width: 300px;margin:10px;letter-spacing:1px;" type="text" name="code" value="<?php echo $_POST['code'];?>"><br>
        <p style="color:red;margin:0;font-size:13px;"><?php echo $vcodeError; ?></p>
        <input style="width:100px ;padding:7px;margin: 20px 0 0 0;cursor: pointer;background-color: rgb(8, 99, 159);border: none;color: white;letter-spacing: 1px;" type="submit" name="verify_button" value="verify">
       
      </form>
    </div>
  
</body>
</html>


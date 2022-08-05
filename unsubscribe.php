<?php 
session_start();
include_once 'dbconnection.php';
$randomToken=(string)$_SESSION['randomDelCode'];
$DelEmail=$_SESSION['to_del'];
$Ucode_error="";

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XKCD</title>
    
</head>
<body style="margin:0 ;padding:0;">

    <?php
        
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['verify'])){
      $Del_code=$_POST['Ucode'];
      if($Del_code===$randomToken){
            $deleteQuery = "DELETE FROM users WHERE email=?";
            $result = mysqli_prepare($conn,$deleteQuery);
            mysqli_stmt_bind_param($result,'s',$DelEmail);
      
            if (mysqli_stmt_execute($result)) {
              echo "<script>alert('Unsubscribed to XKCD successfully');";
              echo "window.location.replace('https://srxkcd.online/index.php'); </script>";
            } else {
              echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
            }

      }else{
        $Ucode_error=" Incorrect verification code";
      }
      
    }
      
      mysqli_close($conn);

    ?>
    
    <div style="background-color: rgb(9, 38, 59);height:80px;text-align: center;padding:0;">
        <div><img style="color:white;" src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/image.png" alt="" width="100" height="80" ></div>
    </div>
    
    <div style="margin:auto;width:400px;text-align:center;">
        <p style="font-size: 30px;font-weight:bold;">Sorry for the inconvenience!!</p>
        <p style="font-size:12px;">Enter your email to unsubscribe and click on the button below.</p>
        <div>
            <form style="margin-bottom:0px;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div style="margin:35px 0 0px 0;">
                    <label style="margin:20px 5px 0 0;">Email</label>
                    <input type="text" name="email" style="padding: 5px;width:250px;outline:none;letter-spacing:1px;" value="<?php echo $DelEmail; ?>" disabled>
                </div>
                <div style="margin:35px 0 0px 0;">
                    <label style="margin:20px 5px 0 0;">Code</label>
                    <input type="text" name="Ucode" style="padding: 5px;width:250px;outline:none;letter-spacing:1px;" value="<?php echo $_POST['Ucode']; ?>" >
                    <p style="margin:5px 0 0 0;color:red;font-size:12px;"><?php echo $Ucode_error; ?></p>
                </div>
                
                <input name="verify" type="submit" style="background-color: rgb(51, 121, 226);border:none;padding:10px;border-radius: 5px;font-weight: bold;cursor: pointer;margin-top:10px;letter-spacing:1px;" value="verify">
            </form>  
           
        </div>
        <p style="border-top:1px solid rgb(207, 205, 205) ;width:370px;margin:20px 0 0 15px;"></p>
        <div><p>&rarr;  <a style="text-decoration: none;color:blue;" href="index.php">go to home</a></p></div>
    </div>
    
</body>
</html>
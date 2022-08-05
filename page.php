<?php 
session_start();
include_once 'email-validation.php';
include_once 'dbconnection.php';
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

    $email=$email_error=null;
    if(isset($_POST['unsubscribe'])){
        $email=$_POST['email'];
        $t = unsub_validation($_POST['email'],$conn);
        if($t!=='valid'){
          $email_error = $t;
        }
      }
  
      if(isset($_POST['unsubscribe']) and unsub_validation($email,$conn)==='valid')
      {
            $randomDelToken = rand(111111,999999);
            $_SESSION['randomDelCode'] = $randomDelToken;
            $to = $_POST['email'];
            $_SESSION['to_del']= $_POST['email'];
            $subject = "XKCD unsubscribtion verification token email";
       $message = '
       <html>
        <body style="background-color: whitesmoke;">
        <div style="width: 400px;margin: auto;text-align: center;background-color: white;border-radius: 5px;padding: 25px;border:1px solid grey;">
            <div>
                <img src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/logo.png" alt="logo" height="80" width="120" >
            </div>
            <div style="border-radius: 5px;padding: 10px;margin-top: 25px;">
                <p style="font-size: 20px;margin:10px 0 20px 0;">verification code</p>
                <p style="font-family:Arial;font-size: 30px;margin: 10px 0;font-weight: 600;letter-spacing: 1px;">'.$randomDelToken.'</p>

            </div>
            <div>
                <p style="font-size: 11px;margin: 10px 0 0px 0;font-family: Arial;">If you received this in error, simply ignore this email.</p>    
            </div>
        </div>
        
        
    </body>
       </html>
       ';
      // The content-type header must be set when sending HTML email
       $headers = "MIME-Version: 1.0" . "\r\n";
       $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
    
       if(mail($to,$subject,$message, $headers)) {
       
            header("Location: https://srxkcd.online/unsubscribe.php");
       } else {
          echo "Message was not sent.";
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
                    <input type="text" name="email" style="padding: 5px;width:250px;outline:none;letter-spacing:1px;" value="<?php echo $email; ?>" >
                    <p style="margin:5px 0 0 0;color:red;font-size:12px;"><?php echo $email_error; ?></p>
                </div>
                
                <input id="myBtn" name="unsubscribe" type="submit" style="background-color: rgb(51, 121, 226);border:none;padding:12px;border-radius: 5px;font-weight: bold;cursor: pointer;margin-top:10px;" value="send code">
            </form>  
           
        </div>
        <p style="border-top:1px solid rgb(207, 205, 205) ;width:370px;margin:20px 0 0 15px;"></p>
        <div><p>&rarr;  <a style="text-decoration: none;color:blue;" href="index.php">go to home</a></p></div>
    </div>
    
</body>
</html>
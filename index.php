<?php 
 session_start();
  include_once 'dbconnection.php';
  include_once 'getLatest.php';
  include_once 'email-validation.php';

  $err=null;
  $email=null;
  
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>XKCD</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js"></script>
  <style>
    @font-face {
	    font-family: xkcd;
	    src: url('https://cdn.rawgit.com/ipython/xkcd-font/master/xkcd-script/font/xkcd-script.woff') format('woff');
    }
    .xkcd {
  	  font-family: xkcd;
    }    
  </style>
  
</head>
<body style="margin:0 ;padding:0;">
  <?php
  ini_set( 'display_errors', 1 );
   error_reporting( E_ALL );
   

    if(isset($_POST['sButton'])){
      $t = validation($_POST['email'],$conn);
      if($t!=='valid'){
        $err = $t;
        $email = $_POST['email'];
        
      }
    }

    if(isset($_POST['sButton']) and validation($_POST['email'],$conn)==='valid')
    {
        $randomToken = rand(111111,999999);
        $_SESSION['randomCode'] = $randomToken;
        $to = $_POST['email'];
        $_SESSION['to_add']= $_POST['email'];

       $subject = "XKCD verification email";
       $message = '
       <html>
        <body style="background-color: whitesmoke;">
        <div style="width: 400px;margin: auto;text-align: center;background-color: white;border-radius: 5px;padding: 25px;border:1px solid grey;">
            <div>
                <img src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/logo.png" alt="logo" height="80" width="120" >
            </div>
            <div style="border-radius: 5px;padding: 10px;margin-top: 25px;">
                <p style="font-size: 20px;margin:10px 0 20px 0;">verification code</p>
                <p style="font-family:Arial;font-size: 30px;margin: 10px 0;font-weight: 600;letter-spacing: 1px;">'.$randomToken.'</p>

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
       
            header("Location: https://srxkcd.online/verifyCode.php");
       } else {
          echo "Message was not sent.";
       }
        }

    mysqli_close($conn);

  ?>

  <!-- Logo section  -->
  <div style="background-color: rgb(9, 38, 59);height:80px;text-align: center;border:1px solid rgb(9, 38, 59);padding:0;">
    <div><img style="color:white;" src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/image.png" alt="" width="100" height="80" ></div>
  </div>

  <!-- XKCD latest section  -->
  <div style="text-align:center;margin-top:15px;">
    <p style="font-size:25px;font-weight:bold;"><?php echo $newTitle; ?></p>
    <img style="margin-bottom:10px;" src="<?php echo $newImg; ?>" alt="<?php echo $newAlt; ?>" width="400" height="400">
    <p style="font-weight:bold;font-size:18px;font-family: xkcd;width:700px;margin:auto;text-transform:uppercase;"><?php echo $newAlt; ?></p>
  </div>

    <!-- footer section -->
  <div style="display: flex;justify-content:center;align-items:center;background-color: rgb(230, 227, 227);margin-top:60px;">
    <div style="padding:15px;font-family: Arial, Helvetica, sans-serif;text-align: center;">
      <p style="font-size: 25px;margin:10px 0 20px 0;">Let's stay in touch</p>
      <p style="font-size: 14px;">All our comics with images will deliver to your inbox after every 5 minutes.</p>
      <div style="width: 390px;background-color: white;border-radius: 5px;margin-left: 40px;">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
          <input style="outline:none;padding: 5px;width: 270px;border: none;height: 20px;margin: 0;letter-spacing: 0.5px;border-radius: 5px 0 0 5px;" type="text" name="email" placeholder="Your Email Address" value="<?= $email; ?>" required>
          <input name='sButton' style="cursor:pointer;margin:0;height: 30px;width: 105px;background-color: orange;border: none;font-weight: bold;color: white;border-radius: 0 5px 5px 0;" type="submit" value="Subscribe" >
        </form>
      </div>
      <p style="margin-top: 5px;color:red;font-size:11px;"><?php echo $GLOBALS['err']; ?></p>
      <p style="font-size: 12px;">We'll never share your email address and you can opt out at any time, we promise.</p>
    </div>
  </div> 
      
  
</body>
</html>

<?php 
  require('DBconnect.php');
  require('interval.php');
  require('email-validation.php');
  $err=null;
  $email=null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
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

    if(isset($_POST['sButton'])){
      $t = validation($_POST['email'],$conn);
      if($t!=='valid'){
        $GLOBALS['err'] = $t;
        $GLOBALS['email']=$_POST['email'];
      }
    }

    if(isset($_POST['sButton']) and validation($_POST['email'],$conn)==='valid')
    {
      $insertQuery = "INSERT INTO user_subscription (email,status_data) VALUES (?,?)";
      $result = mysqli_prepare($conn,$insertQuery);
      $status = "subscribed";
      $email = $_POST['email'];
      mysqli_stmt_bind_param($result,'ss',$email,$status);

      if (mysqli_stmt_execute($result)) {
        echo "<script>alert('Subscribed to XKCD successfully');";
        echo "window.location.href = 'index.php';</script>";
      } else {
        echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
      }
      
    }

    mysqli_close($conn);

  ?>

  <!-- Logo section  -->
  <div style="background-color: rgb(9, 38, 59);height:80px;text-align: center;border:1px solid rgb(9, 38, 59);padding:0;">
    <div><img style="color:white;" src="image.png" alt="" width="100" height="80" ></div>
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
        <form action="index.php" method="post">
          <input style="outline:none;padding: 5px;width: 280px;border: none;height: 20px;margin: 0;letter-spacing: 0.5px;border-radius: 5px 0 0 5px;" type="text" name="email" placeholder="Your Email Address" value="<?= $email; ?>" required>
          <input name='sButton' style="cursor:pointer;margin:0;height: 30px;width: 105px;background-color: orange;border: none;font-weight: bold;color: white;border-radius: 0 5px 5px 0;" type="submit" value="Subscribe" >
        </form>
      </div>
      <p style="margin-top: 5px;color:red;font-size:13px;"><?php echo $GLOBALS['err']; ?></p>
      <p style="font-size: 12px;">We'll never share your email address and you can opt out at any time, we promise.</p>
    </div>
  </div> 
      
</body>
</html>



<?php 
require('email-validation.php');
require('DBconnect.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .modal {
            display: none; 
            margin: auto;
            position: fixed; 
            z-index: 1; 
            left: 0;
            top: 0;
            width: 100%; 
            height: 100%; 
            overflow: auto; 
            background-color: rgb(0,0,0); 
            background-color: rgba(0,0,0,0.4); 
            -webkit-animation-name: fadeIn; 
            -webkit-animation-duration: 0.4s;
            animation-name: fadeIn;
            animation-duration: 0.4s
        }
    
        .modal-content {
            border-radius: 5px;
            position: relative;
            top: 30%;
            left: 35%;
            bottom: 0;
            background-color: #fefefe;
            width: 30%;
            -webkit-animation-name: slideIn;
            -webkit-animation-duration: 0.4s;
            animation-name: slideIn;
            animation-duration: 0.4s
        }
    
        .close {
            color: grey;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,.close:focus {
            color: #000;
            text-decoration: none;
            cursor: pointer;
        }
    
        .modal-header {
            padding: 2px 16px;
            height: 20px;
            color: white;
        }
        
        .modal-body {
            padding: 10px 16px 20px 20px;
            height: auto;
            margin: 30px 0 0 0;
            font-size: 18px;
            letter-spacing: 0.5px;
            line-height: 25px;
        }
        
        @-webkit-keyframes slideIn {
            from {bottom: -300px; opacity: 0} 
            to {bottom: 0; opacity: 1}
        }
        
        @keyframes slideIn {
            from {bottom: -300px; opacity: 0}
            to {bottom: 0; opacity: 1}
        }
        
        @-webkit-keyframes fadeIn {
            from {opacity: 0} 
            to {opacity: 1}
        }
        
        @keyframes fadeIn {
            from {opacity: 0} 
            to {opacity: 1}
        }
    </style>
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
        $deleteQuery = "DELETE FROM user_subscription WHERE email=?";
        $result = mysqli_prepare($conn,$deleteQuery);
        mysqli_stmt_bind_param($result,'s',$email);
  
        if (mysqli_stmt_execute($result)) {
          echo "<script>alert('Unsubscribed to XKCD successfully');";
          echo "window.location.href = 'index.php';</script>";
        } else {
          echo "Error: " . $deleteQuery . "<br>" . mysqli_error($conn);
        }
        
      }
  
      mysqli_close($conn);

    ?>
    <div style="background-color: rgb(9, 38, 59);height:80px;text-align: center;padding:0;">
        <div><img style="color:white;" src="image.png" alt="" width="100" height="80" ></div>
    </div>
    <div style="display: flex;align-items: center;justify-content: center;">
        <div style="top: 10%;transform: translateY(0%);">
            <p style="font-size: 30px;font-weight:bold;margin-left: 20px;">Sorry for the inconvenience!!</p>
            <p>Enter your email to unsubscribe and click on the button below.</p>
            <div>
                <form style="margin-bottom:0px;" action="page.php" method="post">
                    <input type="text" name="email" style="padding: 10px;width:280px;outline:none;" value="<?= $email; ?>" required>
                    <input id="myBtn" name="unsubscribe" type="submit" style="background-color: rgb(51, 121, 226);border:none;padding:12px;border-radius: 5px;font-weight: bold;cursor: pointer;" value="unsubscribe">
                </form>  
                <p style="color:red;margin:5px 0 5px 0px;font-size:13px;"><?php echo $email_error; ?></p>
                
            </div>
            <p style="border-top:1px solid rgb(207, 205, 205) ;width:370px;margin:30px 0 0 15px;"></p>
            <div style="text-align:center;"><p>&rarr;  <a style="text-decoration: none;color:blue;" href="index.php">go to home</a></p></div>
        </div>
        
    </div>
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header">
                <span class="close">&times;</span>
            </div>

            <div class="modal-body">
                <p>You have successfully unsubscribed from our mailing list.</p>
            </div>

          
        </div>  
      </div>
    <script>
        
        var modal = document.getElementById("myModal");
        
        var btn = document.getElementById("myBtn");
        
        var span = document.getElementsByClassName("close")[0];
        
        // btn.onclick = function() {
        //     modal.style.display = "block";
        // }s
        
        span.onclick = function() {
            modal.style.display = "none";
        }
        
        window.onclick = function(event) {
            if (event.target == modal) {
            modal.style.display = "none";
            }
        }
    </script>
</body>
</html>
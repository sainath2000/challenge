<?php

require('interval.php');


function fetchFunction($newNumber){
    $connect = mysqli_connect("localhost", "root", "","php-project");
    $fetchQuery = "SELECT email FROM user_subscription WHERE status_data = ?";
    $stmt = mysqli_prepare($connect,$fetchQuery);
    $status = "subscribed";
    mysqli_stmt_bind_param($stmt,'s',$status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    mysqli_close($connect);
    $random = rand(1,$newNumber);
    $randomData = FindData($random);
    $logo = "http://localhost/projects/official%20projects/web%20template/myfirstproject/logo.png";
    $headers = "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    $subject = "XKCD";
    $htmlContent='
    
    <html>
    <head>
        
        <title>Email</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Shadows+Into+Light&display=swap" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/webfont/1.6.28/webfontloader.js"></script>
        <style>
            @font-face {
                font-family: xkcd;
                src: url("https://cdn.rawgit.com/ipython/xkcd-font/master/xkcd-script/font/xkcd-script.woff") format("woff");
            }
            .xkcd {
            font-family: xkcd;
            }    
        </style>
        
    </head>
    <body style="background-color: whitesmoke;">
        <div style="width: 400px;margin: auto;text-align: center;background-color: white;border-radius: 5px;padding: 25px;">
            <div>
                <img src="'.$logo.'" alt="logo" height="80" width="120" >
            </div>
            <div style="border:1px solid black;border-radius: 5px;padding: 10px;margin-top: 25px;">
                <p style="font-size: 30px;margin:10px 0;font-weight: bold;">'.$randomData->title.'</p>
                <img src="'.$randomData->img.'" alt="" height="200" width="200" >
                <p style="font-family: "Shadows Into Light", cursive;font-size: 30px;margin: 10px 0;">'.$randomData->alt.'</p>
            </div>
            <div>
                <p style="font-size: 14px;margin: 10px 0 0px 0;line-height: 30px;">If you would like to stop receiving these emails,</p>
                <a style="cursor:pointer;font-size: 16px;text-decoration:none;font-family:xkcd;color:blue;" href="http://localhost/projects/official%20projects/web%20template/myfirstproject/page.php">click here to unsubscribe</a>
            </div>
        </div>
        
        
    </body>
    </html>
    ';

    while($row = mysqli_fetch_assoc($result))
    {
        mail($row["email"],$subject,$htmlContent,$headers);
        
    }
}


// $count =0;
// while($count<5){
//     fetchFunction($newNumber);
//     sleep(5);
//     $count+=1;
//     echo $count;
// }
fetchFunction($newNumber);


?>
<?php
include_once 'getLatest.php';
include_once 'dbconnection.php';

function getCount($connect){
    $selQ = "SELECT COUNT(*) as count FROM users";
    $result = mysqli_query($connect,$selQ);
    if(!$result){
        echo mysqli_error($connect);
        
    }else{
        $count = mysqli_fetch_array($result);
    }
    return $count['count'];
}




function fetchFunction($newNumber,$connect){
   
    $fetchQuery = "SELECT email FROM users WHERE status = ?";
    $stmt = mysqli_prepare($connect,$fetchQuery);
    $status = "subscribed";
    mysqli_stmt_bind_param($stmt,'s',$status);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $random = rand(1,$newNumber);
    $randomData = FindData($random);
    //$logo = "https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/logo.png";
    
    $imageUrl = $randomData->img;

    // Image file.
    $imageFile = file_get_contents($imageUrl);
    
    $tokens = explode('/', $imageUrl);
    
    // File name.
    $fileName = $tokens[(count($tokens) - 1)];
    
    // File extension.
    $ext = explode(".", $fileName);
    
    // File type.
    $fileType = $ext[1];
    
    // File size.
    $header = get_headers($imageUrl, true);
    
    // $from = "srinivas4204klu@gmail.com";
    $headers = "From: srinivas4204klu@gmail.com" . "\r\n" ;
    // $headers .= "MIME-Version: 1.0" . "\r\n"; 
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n"; 
    // $headers .= "From:" . $from;
    $subject = "XKCD";
    $message='
    
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
                <img src="https://res.cloudinary.com/tracercloud/image/upload/v1655731865/remote_project/logo.png" alt="logo" height="80" width="120" >
            </div>
            <div style="border:1px solid black;border-radius: 5px;padding: 10px;margin-top: 25px;">
                <p style="font-size: 30px;margin:10px 0;font-weight: bold;">'.$randomData->title.'</p>
                <img src="'.$randomData->img.'" alt="" height="200" width="200" >
                <p style="font-family: "Shadows Into Light", cursive;font-size: 30px;margin: 10px 0;">'.$randomData->alt.'</p>
            </div>
            <div>
                <p style="font-size: 14px;margin: 10px 0 0px 0;line-height: 30px;">If you would like to stop receiving these emails,</p>
                <a style="cursor:pointer;font-size: 16px;text-decoration:none;font-family:xkcd;color:blue;" href="https://srxkcd.online/page.php">click here to unsubscribe</a>
            </div>
        </div>
        
        
    </body>
    </html>
    ';
        // File.
    $content = chunk_split(base64_encode($imageFile));
    
    // A random hash will be necessary to send mixed content.
    $semiRand     = md5(time());
    $mimeBoundary = '==Multipart_Boundary_x{$semiRand}x';
    
    // Carriage return type (RFC).
    $eol = "\r\n";
    $headers = "From:" . $from;
    
    $headers .= 'Reply-To: Name <name@example.com>'.$eol;
    $headers .= 'Return-Path: Name <name@example.com>'.$eol;
    $headers  = 'MIME-Version: 1.0'.$eol;
    $headers .= "Content-Type: multipart/mixed; boundary=\"{$mimeBoundary}\"".$eol;
    $headers .= 'Content-Transfer-Encoding: 7bit'.$eol;
    $headers .= 'X-Priority: 3'.$eol;
    $headers .= 'X-Mailer: PHP'.phpversion().$eol;
    
    // Message.
    $body  = '--'.$mimeBoundary.$eol;
    $body .= "Content-Type: text/html; charset=\"UTF-8\"".$eol;
    $body .= 'Content-Transfer-Encoding: 7bit'.$eol;
    $body .= $message.$eol;
    
    // Attachment.
    $body .= '--'.$mimeBoundary.$eol;
    $body .= "Content-Type:{$fileType}; name=\"{$fileName}\"".$eol;
    $body .= 'Content-Transfer-Encoding: base64'.$eol;
    $body .= "Content-disposition: attachment; filename=\"{$fileName}\"".$eol;
    $body .= 'X-Attachment-Id: '.rand(1000, 99999).$eol;
    $body .= $content.$eol;
    $body .= '--'.$mimeBoundary.'--';

    while($row = mysqli_fetch_assoc($result))
    {
       
        mail($row["email"],$subject,$body,$headers);
        
    }
    
}


if(getCount($conn)>0){
    
    fetchFunction($newNumber,$conn);
    echo "sent";
}else{
    echo "no subscribers";
}



?>

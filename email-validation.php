<?php
require('DBconnect.php');


function checkfunc($x){
  $c=0;
  for($i=0;$i<strlen($x);$i++){
    if(ctype_alpha($x[$i]) or is_numeric($x[$i]) or $x[$i]==='.'){
      $c+=1;
    }
  }
  if(strlen($x)==$c){
    return 1;
  }else{
    return 0;
  }
}

function checkExist($connect,$email){
  $selectQuery = "SELECT * FROM user_subscription WHERE email = ?";
  $stmt = mysqli_prepare($connect,$selectQuery);
  mysqli_stmt_bind_param($stmt,'s',$email);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  return $result;
}


function validation($email,$connect){
  $low=strtolower($email);
  $ext = strrev(substr(strrev($low),0,10));
  $start =strrev(substr(strrev($low),10));
  $error="valid";
  $count = checkExist($connect,$low);
  
  if(strlen($start)<2){
    $error = "email is not valid";
  }else if($ext!=="@gmail.com"){
    $error = "only gmail domain is allowed";
  }else if(checkfunc($start)==0){
    $error =" only alphabets(a-z) numbers(0-9) dot operator(.) is allowed ";
  }else if($start[0]=='.'){
    $error="username must start with letters,numbers";
  }else if(mysqli_num_rows($count)>=1){
    $error="email already exist";
  }
  return $error;

}

function unsub_validation($email,$connect){
  $low=strtolower($email);
  $ext = strrev(substr(strrev($low),0,10));
  $start =strrev(substr(strrev($low),10));
  $error="valid";
  $count = checkExist($connect,$low);
  
  if(strlen($start)<2){
    $error = "email is not valid";
  }else if($ext!=="@gmail.com"){
    $error = "only gmail domain is allowed";
  }else if(checkfunc($start)==0){
    $error =" only alphabets(a-z) numbers(0-9) dot operator(.) is allowed ";
  }else if($start[0]=='.'){
    $error="username must start with letters,numbers";
  }else if(mysqli_num_rows($count)==0){
    $error="email doesn't exist";
  }
  return $error;

}


?>


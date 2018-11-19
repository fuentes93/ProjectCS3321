<?php

function isempty($str){
    return $str=='';
}
function error($message){
        header("Location: ../signup.php?signup=".$message);
        exit();
}
if(isset($_POST['submit'])){
$dbServername = "localhost";
$dbUsername = "id5086538_luisdevin";
$dbPassword ="fuqazwsx";
$dbName ="id5086538_project0";

$conn=mysqli_connect("localhost", "id5086538_luisdevin","fuqazwsx", "id5086538_project0");
 $first = mysqli_real_escape_string($conn,$_POST['first']);
    $last = mysqli_real_escape_string($conn,$_POST['last']);
    $email = mysqli_real_escape_string($conn,$_POST['email']);
    $uid = mysqli_real_escape_string($conn,$_POST['uid']);
    $pwd = mysqli_real_escape_string($conn,$_POST['pwd']);
    //Error hadnling
    if(empty($first)||empty($last)||empty($email)||empty($uid)||empty($pwd)){
            error('empty');
 
    }else{
        //Check if chars are bad
        if(!preg_match("/^[a-zA-Z]*$/",$first)||!preg_match("/^[a-zA-Z]*$/",$last)){
            error('invalid');
 
        } else{
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                error('email');
 
            }
            else{
                $sql = "SELECT * FROM users WHERE user_uid = '$uid';";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
                if($resultCheck>0){
                    error('taken');
                }else{
                    $hashedPwd = password_hash($pwd,PASSWORD_DEFAULT);
                    $sql = "INSERT INTO users (user_first,user_last,user_email,user_uid,user_pwd) VALUES ('$first','$last','$email','$uid','$hashedPwd');";
                    $result = mysqli_query($conn,$sql);
                    error('success');
                }
            }
 
        }
    }
 
}else{
    error('invalid_source');
}

<?php 
include('config.php') ; 

require "vendor/autoload.php";
use \Firebase\JWT\JWT;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($uname && $password){

    $sql = mysqli_query($con,"select * from mis_loginusers where uname = '".$uname."' and pwd='".$password."' and user_status=1");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                
                $fname = $sql_result['name'];
                $email = $sql_result['uname'];
                $userid = $sql_result['id'];
                $contact = $sql_result['contact'];
                
                $secret_key = "Advantage";
        		$issuedat_claim = time(); // issued at
        		$notbefore_claim = $issuedat_claim + 10; //not before in seconds
        		$expire_claim = $issuedat_claim + 60; // expire time in seconds
        		
                $token = array(
                    "nbf" => $notbefore_claim,
                    "exp" => $expire_claim,
                    "data" => array(
                        "id" => $userid,
                        "fullname" => $fname,
                        "email" => $email,
                ));
                $jwt = JWT::encode($token, $secret_key,"HS256");
                $token_sql = "update mis_loginusers set token='".$jwt."' , updated_at = '".$datetime."' where id='".$userid."'";
                mysqli_query($con,$token_sql) ;                
                    
                $data = ['statusCode'=>200,'userid'=>$userid,'name'=>$fname,'email'=>$email,'contact'=>$contact,'token'=>$jwt];
             }
    }else{
        $data = ['statusCode'=>400,'message'=>'Unauthorised Access !'];
    }
}else{
    $data = ['statusCode'=>500,'message'=>'Username or password cannot be empty !'];
}

echo json_encode($data);

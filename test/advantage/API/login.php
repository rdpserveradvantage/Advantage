<?php 
include('config.php');

require "vendor/autoload.php";
use \Firebase\JWT\JWT;

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($uname && $password){

    // Check in mis_loginusers table
    $sql_mis = mysqli_query($con, "SELECT * FROM mis_loginusers WHERE uname = '".$uname."' AND pwd='".$password."' AND user_status=1");
    $result_mis = mysqli_num_rows($sql_mis);
    
    // Check in vendorUsers table
    $sql_vendor = mysqli_query($con, "SELECT * FROM vendorUsers WHERE uname = '".$uname."' AND password='".$password."' AND user_status=1");
    $result_vendor = mysqli_num_rows($sql_vendor);
    
    if($result_mis > 0){
        $sql_result = mysqli_fetch_assoc($sql_mis);
        $user_table = 'mis_loginusers';
        $vendor=0;
    }
    elseif($result_vendor > 0){
        $sql_result = mysqli_fetch_assoc($sql_vendor);
        $user_table = 'vendorUsers';
        $vendor=1;
    }
    else {
        $data = ['statusCode'=>400,'message'=>'Unauthorised Access !'];
        echo json_encode($data);
        exit;
    }

    if($sql_result['user_status'] == 1){
        
        if($vendor==1){
            $vendorID = $sql_result['vendorId'];
        }else{
            $vendorID = false ; 
        }
        
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
            )
        );
        $jwt = JWT::encode($token, $secret_key, "HS256");

        // Update token in the respective table
        $token_sql = "UPDATE " . $user_table . " SET token='".$jwt."', updated_at='".$datetime."' WHERE id='".$userid."'";
        mysqli_query($con, $token_sql);                

        $data = ['statusCode'=>200,'userid'=>$userid,'name'=>$fname,'email'=>$email,'contact'=>$contact,'token'=>$jwt,'vendor'=>$vendor,'vendorID'=>$vendorID];
        echo json_encode($data);
    }
    else{
        $data = ['statusCode'=>400,'message'=>'Unauthorised Access !'];
        echo json_encode($data);
    }
}
else{
    $data = ['statusCode'=>500,'message'=>'Username or password cannot be empty !'];
    echo json_encode($data);
}

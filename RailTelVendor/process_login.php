<?php include('config.php') ;

require "vendor/autoload.php";
use \Firebase\JWT\JWT;

$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($uname && $password){

    $sql = mysqli_query($con, "SELECT * FROM vendorUsers WHERE (uname = '$uname' OR contact = '$uname') AND password = '$password' AND user_status = 1 and level in (1,2)");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                $_SESSION['VENDOR_auth']=1;
                $_SESSION['VENDOR_isVendorPortal'] = 1 ; 
                $_SESSION['VENDOR_username']=$sql_result['name'];
                $_SESSION['VENDOR_email']=$sql_result['uname'];

                $_SESSION['VENDOR_userid'] = $sql_result['id'];
                $_SESSION['VENDOR_level'] = $sql_result['level'];
                $_SESSION['VENDOR_RailTailVendorID'] = $sql_result['vendorId'];
                $_SESSION['VENDOR_branch'] = $sql_result['branch'];
                $_SESSION['VENDOR_zone'] = $sql_result['zone'];
                $_SESSION['VENDOR_cust_id'] = $sql_result['cust_id'];
                $_SESSION['VENDOR_RailTelVendorSite'] = 1;
                $_SESSION['VENDOR_site'] = 'RailTelVendorSite';
                
                
                $userid = $sql_result['id'];
                $secret_key = "RailTailVendor";
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
                $token_sql = "update vendorUsers set token='".$jwt."' , updated_at = '".$datetime."' where id='".$userid."'";
                    mysqli_query($con,$token_sql) ;                
                    
                
                $_SESSION['VENDOR_token'] = $jwt ;
                
          
          
          $_SESSION['ADVANTAGE_vendortoken'] = $jwt ;
                $response['success'] = true;
                $response['redirect'] = 'index.php'; // Change this to your actual redirect URL

                
                
    header('Content-Type: application/json');
    echo json_encode($response);               
               
                     
           }else{
        $_SESSION['VENDOR_isVendorPortal'] = 0 ; 

                    $response['success'] = false;
                    $response['message'] = 'Invalid username or password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
                

               
           }  
    }else{
                    $response['success'] = false;
                    $response['message'] = 'Invalid username or password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
               } 

    
    
}
else{ 
    $response['success'] = false;
                    $response['message'] = 'Please provide both username and password';
                    $response['redirect'] = 'login.php'; // Change this to your actual redirect URL
                    header('Content-Type: application/json');
                    echo json_encode($response);
    }

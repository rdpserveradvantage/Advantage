<?php session_start();
session_destroy();
include('config.php') ; ?>
<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>
        


<?php

require "vendor/autoload.php";
use \Firebase\JWT\JWT;


$uname = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($uname && $password){

    $sql = mysqli_query($con,"select * from inventoryUsers where uname = '".$uname."' and password='".$password."' and user_status=1");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                $_SESSION['auth']=1;
                $_SESSION['isVendorPortal'] = 1 ; 
                $_SESSION['username']=$sql_result['name'];
                $_SESSION['userid'] = $sql_result['id'];
                $_SESSION['level'] = $sql_result['level'];
                $_SESSION['advantageInventory'] = 1;
                $_SESSION['site'] = 'advantageInventory';
                
                $_SESSION['branch'] = $sql_result['branch'];
                $_SESSION['zone'] = $sql_result['zone'];
                $_SESSION['cust_id'] = $sql_result['cust_id'];
                
                $userid = $sql_result['id'];
                $secret_key = "advantageInventory";
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
                $token_sql = "update inventoryUsers set token='".$jwt."' , updated_at = '".$datetime."' where id='".$userid."'";
                    mysqli_query($con,$token_sql) ;                
                    
                
                $_SESSION['advantageInventorytoken'] = $jwt ;
                
                
                ?>
               <script>
               swal("Good job!", "Login Success !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="index.php";
                   }, 3000);
        
               </script> 
        <? }else{
        $_SESSION['advantageInventory'] = 0;
                
        ?>       
                <script>
                   swal("Error", "You are inactive !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        <? } ?>           
    <? }else{ ?>
       <script>
       swal("Error", "Incorrect Username or Password !", "error");
           swal('error','','Login Error');
           setTimeout(function(){ 
              window.history.back();
           }, 3000);

       </script>
<? }

    
    
}
else{ ?>
       <script>
       swal("Error", "Please Put Username and Password  !", "error");
            setTimeout(function(){ 
              window.history.back();
           }, 3000);

       </script>
<? }

?>
    </body>
</html>
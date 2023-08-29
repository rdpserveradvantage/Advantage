<?php include('config.php') ; ?>
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


    $sql = mysqli_query($con,"select * from vendorUsers where uname = '".$uname."' and password='".$password."' and user_status=1 and level=3");
    $result = mysqli_num_rows($sql);
    if($result>0){
        $sql_result = mysqli_fetch_assoc($sql);
        if($sql_result['user_status']==1){
                $_SESSION['PROJECT_auth']=1;
                $_SESSION['PROJECT_isProjectPortal'] = 1 ; 
                $_SESSION['PROJECT_username']=$sql_result['name'];
                $_SESSION['PROJECT_userid'] = $sql_result['id'];
                $_SESSION['PROJECT_level'] = $sql_result['level'];
                $_SESSION['PROJECT_RailTailVendorID'] = $sql_result['vendorId'];
                $_SESSION['PROJECT_branch'] = $sql_result['branch'];
                $_SESSION['PROJECT_zone'] = $sql_result['zone'];
                $_SESSION['PROJECT_cust_id'] = $sql_result['cust_id'];
                
                $userid = $sql_result['id'];
                $secret_key = "RailTailProject";
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
                    
                
                $_SESSION['PROJECT_isProjectPortalToken'] = $jwt ;
                
                
                ?>
               <script>
               swal("Good job!", "Login Success !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="index.php";
                   }, 3000);
        
               </script> 
        <? }else{
        $_SESSION['PROJECT_isVendorPortal'] = 0 ; 
                
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
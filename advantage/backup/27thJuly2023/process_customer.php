<?php session_start();
include('config.php') ; ?>
<html>
    <head>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>        
    </head>
    <body>
        

<?

$customerName = $_REQUEST['name'];

if($customerName){
    
    $sql = "insert into customer(customerName,status) values('".$customerName."',1)";
    
    if(mysqli_query($con,$sql)){
        ?>
        
        
            <script>
               swal("Good job!", "Customer Added Successfully !", "success");
        
                   setTimeout(function(){ 
                      window.location.href="customer.php";
                   }, 3000);
        
               </script> 
               
               
               <?
        
        
        
        
    }else{ ?>
    
    
    <script>
                   swal("Error", "Error While Adding Customer !", "error");
                      
                       setTimeout(function(){ 
                          window.history.back();
                       }, 3000);
            
                   </script>
        
    <? }
}



?>
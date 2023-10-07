<? include('config.php');

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];


// var_dump($_REQUEST);

if(isset($redelegate) && !empty($redelegate)){
    
    $statement2 = "update delegation set status=0 where siteid='".$siteid."'";
    if(mysqli_query($con,$statement2)){
        
    }
    $statement = "insert into delegation(siteid,engineerId,status,created_at) 
        values('".$siteid."','".$engineer."',1,'".$datetime."')";
        
        if(mysqli_query($con,$statement)){
            echo 202;
        }
    
    
            
                
            
            
    }else{
        
        $statement = "insert into delegation(siteid,engineerId,status,created_at) 
        values('".$siteid."','".$engineer."',1,'".$datetime."')";
        
        if(mysqli_query($con,$statement)){
    
        if(mysqli_query($con,$update = "update sites set isDelegated=1 where id='".$siteid."'")){
            echo json_encode(200);
        }
    }

}

?>
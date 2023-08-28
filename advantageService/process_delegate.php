<? include('config.php');

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];

$vendor = $RailTailVendorID;
$vendorName = getVendorName($vendor);


// var_dump($_REQUEST);

if(isset($redelegate) && !empty($redelegate)){
    
    $statement2 = "update delegation set status=0 where siteid='".$siteid."'";
    if(mysqli_query($con,$statement2)){
        
    }
    $statement = "insert into delegation(siteid,engineerId,status,created_at,vendorId,vendorName) 
        values('".$siteid."','".$engineer."',1,'".$datetime."','".$RailTailVendorID."','".$RailTailVendorName."')";
        
        if(mysqli_query($con,$statement)){
            
              mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by) 
                    values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."')");
                    
            echo 202;
            
        }
    
    
            
                
            
            
    }else{
        
        $statement = "insert into delegation(siteid,engineerId,status,created_at,vendorId,vendorName) 
        values('".$siteid."','".$engineer."',1,'".$datetime."','".$RailTailVendorID."','".$RailTailVendorName."')";
        
        if(mysqli_query($con,$statement)){
    
        if(mysqli_query($con,$update = "update sites set delegatedByVendor=1 where id='".$siteid."'")){
            
              mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by) 
                    values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."')");
                    
            echo json_encode(200);
        }
    }

}

?>
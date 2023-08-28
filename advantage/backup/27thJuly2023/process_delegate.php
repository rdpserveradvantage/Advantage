<? include('config.php');

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];
$delegateTo = $_REQUEST['delegateTo'];
$vendor = $_REQUEST['vendor'];
$vendorName = getVendorName($vendor);


if(isset($redelegate) && !empty($redelegate)){
    $statement2 = "update delegation set status=0 where siteid='".$siteid."'";
    if(mysqli_query($con,$statement2)){
        
    }
          loggingRecords('sites', $siteid,'log_before');
        if(mysqli_query($con,"update sites set delegatedToVendorId = 1,delegatedToVendorId='".$vendor."',delegatedToVendorName='".$vendorName."' where id='".$siteid."'")){
            loggingRecords('sites', $siteid,'log_after');
            mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
            values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Advantage')");
            echo json_encode(202);
            delegateToVendor($siteid,$atmid,'');
        }

    }else{
        
        $statement = "insert into delegation(siteid,engineerId,status,created_at) 
        values('".$siteid."','".$engineer."',1,'".$datetime."')";
        
        if(mysqli_query($con,$statement)){
    
        loggingRecords('sites', $siteid,'log_before');
        if(mysqli_query($con,$update = "update sites set isDelegated=1,delegatedToVendorId = '".$vendor."' where id='".$siteid."'")){
        loggingRecords('sites', $siteid,'log_after');
        
            mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
            values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Advantage')");
            echo json_encode(200);
            delegateToVendor($siteid,$atmid,'');

        }
    }

}

?>
<? include('config.php');

$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];
$delegateTo = $_REQUEST['delegateTo'];
$vendor = $_REQUEST['vendor'];
$vendorName = getVendorName($vendor);


 if(isset($redelegate) && !empty($redelegate)){

        loggingRecords('sites', $siteid,'log_before');
        if(mysqli_query($con,"update sites set delegatedToVendorId = 1,delegatedToVendorId='".$vendor."',delegatedToVendorName='".$vendorName."' where id='".$siteid."'")){
            loggingRecords('sites', $siteid,'log_after');
            mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
            values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Advantage')");
            echo json_encode(202);
            delegateToVendor($siteid,$atmid,'');
            addNotification('Advantage', $userid, $vendor, ' 1 New Site Delegated ! ', $siteid, $atmid);
        }

    }else{
        loggingRecords('sites', $siteid,'log_before');
        if(mysqli_query($con,$update = "update sites set isDelegated=1,delegatedToVendorId = '".$vendor."' where id='".$siteid."'")){
        loggingRecords('sites', $siteid,'log_after');
        
        mysqli_query($con,"insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
            values('".$vendor."','".$vendorName."','".$siteid."','".$atmid."',1,'".$datetime."','".$userid."','Advantage')");
            echo json_encode(200);
            delegateToVendor($siteid,$atmid,'');
            addNotification('Advantage', $userid, $vendor, ' 1 New Site Delegated ! ', $siteid, $atmid);


    }

}

?>
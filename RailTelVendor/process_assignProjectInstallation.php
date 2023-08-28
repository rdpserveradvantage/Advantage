<? include('config.php');

$id = $_REQUEST['id'];
$atmid = $_REQUEST['atmid'];
$siteid = $_REQUEST['siteid'];
$engineer = $_REQUEST['engineer'];
$vendorId = $RailTailVendorID ; 
$vendorName = $RailTailVendorName ;

$engineerName = vendorUsersData($engineer,'name') ;

$sql = "insert into assignedInstallation(vendorId, siteid, vendorName, atmid, assignedToId, assignedToName, created_at, created_by, portal, status, remarks) 
        values('".$vendorId."','".$siteid."','".$vendorName."','".$atmid."','".$engineer."','".$engineerName."','".$datetime."','".$userid."','Vendor',1,'')";
    
    if(mysqli_query($con,$sql)){
        
        $a = "update projectInstallation set isSentToEngineer=1 where id = '".$id."'";
        if(mysqli_query($con,$a)){
            echo json_encode(200);
            installationProceedFromVendor($siteid,$atmid,'');
        }
    }    else{
        echo json_encode(500);
    }

?>
<? include('config.php');

$vendorid = $_REQUEST['vendor'];
$vendorName = getVendorName($vendorid);

$atmid = $_REQUEST['atmid'];
$atmid_ar = explode(' ',$atmid);

foreach($atmid_ar as $atmidkey=>$atmidvalue){
    
                $check_sql = mysqli_query($con,"select id,atmid from sites where atmid='".$atmidvalue."' and status=1");
                if($check_sql_result = mysqli_fetch_assoc($check_sql)){
                    $siteid = $check_sql_result['id'];
                    $atmid; 
                    $vendorid;
                    $vendorName;
                    
                    $delegateSql = "insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by) 
                        values('".$vendorid."','".$vendorName."','".$siteid."','".$atmidvalue."',1,'".$datetime."','".$userid."')";
                    if(mysqli_query($con,$delegateSql)){
                        
                        loggingRecords('sites', $siteid,'log_before');
                        

                        $update = "update sites set isDelegated=1,delegatedToVendorId='".$vendorid."',delegatedToVendorName='".$vendorName."' where id='".$siteid."'" ; 
                        if(mysqli_query($con,$update)){
                            echo 'ATMID : ' . $atmidvalue .' Delegated to ' . $vendorName .'<br />' ;
                            loggingRecords('sites', $siteid,'log_after');
                            delegateToVendor($siteid,$atmidvalue,'');
                        }
                        
                    }   
                }
            }


?>
<a href="sitestest.php">Back</a>
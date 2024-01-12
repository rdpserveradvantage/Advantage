<? include('../header.php'); ?>



<div class="row">
    <div class="col-sm-12">

        <div class="card">
            <div class="card-body">

            <?


$response = array(); 

$siteids = $_REQUEST['siteid'];
$siteidar = explode(',', $siteids);

$atmid = $_REQUEST['atmid'];
$atmid = explode(',', $atmid);

$engineer = $_REQUEST['engineer'];
$redelegate = $_REQUEST['action'];
$delegateTo = $_REQUEST['delegateTo'];
$vendor = $_REQUEST['vendor'];
$vendorName = getVendorName($vendor);

$i = 0;

foreach ($siteidar as $siteidarkey => $siteid) {


    loggingRecords('sites', $siteid, 'log_before');

    // $siteid = intval($siteid); // Convert siteid to an integer
    $updatesql = "update sites set isDelegated=1, delegatedToVendorId = '" . $vendor . "', 
    delegatedToVendorName='" . $vendorName . "' where id='" . $siteid . "'";

    $delegationStatus = array(
        'siteid' => $siteid,
        'atmid' => $atmid[$i],
        'success' => false
    );

    if (mysqli_query($con, $updatesql)) {
        loggingRecords('sites', $siteid, 'log_after');
        if (mysqli_query($con, "insert into vendorSitesDelegation(vendorid,vendorName,siteid,amtid,status,created_at,created_by,portal) 
        values('" . $vendor . "','" . $vendorName . "','" . $siteid . "','" . $atmid[$i] . "',1,'" . $datetime . "','" . $userid . "','Advantage')")) {
            delegateToVendor($siteid, $atmid[$i], '');
            addNotification('Advantage', $userid, $vendor, ' 1 New Site Delegated ! ', $siteid, $atmid[$i]);
            $delegationStatus['success'] = true;

            echo $atmid[$i] . ' delegated Successfully ! <br />'  ;
        }
    }

    $response[] = $delegationStatus;
    $i++;
}

?>

</div>
        </div>
    </div>
</div>



<? include('../footer.php'); ?>
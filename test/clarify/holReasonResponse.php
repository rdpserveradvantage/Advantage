<? include('config.php');

$vendorSql = mysqli_query($con,"select * from vendorUsers where id='".$userid."'");
$vendorSqlResult = mysqli_fetch_assoc($vendorSql);
$vendorId = $vendorSqlResult['vendorId'];
$vendorName = getUsername($vendorId);


$atmid = $_REQUEST['atmid'];
$dependency = $_REQUEST['dependency'];
$electricalIssue = $_REQUEST['electricalIssue'];
$hardwareDependency = $_REQUEST['hardwareDependency'];
$powerIssue = $_REQUEST['powerIssue'];
$siteid = $_REQUEST['siteid'];
$softwareDependency = $_REQUEST['softwareDependency'];
$upsIssue = $_REQUEST['upsIssue'];
$engineerName = $_REQUEST['engineerName'];
$engineerid = $_REQUEST['engineerid'];

$sql = "INSERT INTO holdInstallation (siteid, atmid, vendorId, vendorName, customerDependency,powerIssue,upsIssue,electricalDependency, hardwareDependency,  softwareDependency, engineerId,engineerName,created_at,created_by,status,portal) 
        VALUES ('".$siteid."', '".$atmid."', '".$vendorId."', '".$vendorName."', '".$dependency."','".$powerIssue."','".$upsIssue."','".$electricalIssue."',  '".$hardwareDependency."', '".$softwareDependency."', '".$engineerid."','".$engineerName."','".$datetime."','".$userid."',1,'Project')" ;




if (mysqli_query($con,$sql)) {
    echo json_encode(200);
    projectTeamInstallationHold($siteid,$atmid,'');
    
} else {
    echo json_encode(500);
}

$con->close();




?>
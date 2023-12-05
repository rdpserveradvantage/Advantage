<? include('config.php');

$id = $_POST['id'];
$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$challanNumber = $_POST['pod'];
$receiversName = $_POST['receiversName'];
$receiversNumber = $_POST['receiversNumber'];
$receivedDate = $_REQUEST['receivedDate'];
$receivedTime = $_REQUEST['receivedTime'];

// Create the upload directory path based on year and month
$year = date('Y');
$month = date('m');
$uploadDir = "uploadData/trackingUpdates/$year/$month/$atmid/";

// Ensure the directory exists or create it
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

$lrCopyPath = "";
$deliveryChallanPath = "";



$sql = "INSERT INTO trackingDetailsUpdate (materialSendId,atmid, siteid, challanNumber, receiversName, receiversNumber, lrCopyPath, deliveryChallanPath,portal,status,receivedDate,receivedTime)
        VALUES ('$id','$atmid', '$siteid', '$challanNumber', '$receiversName', '$receiversNumber', '$lrCopyPath', '$deliveryChallanPath','Inventory',1,'$receivedDate','$receivedTime')";

if ($con->query($sql) == TRUE) {
    $insert_id = $con->insert_id;
    mysqli_query($con, "update vendorMaterialSend set isConfirm=1, confirmID='" . $insert_id . "' where id='" . $id . "'");
    $data = ['status' => 200, 'message' => 'Updated Successfully !'];
} else {
    $data = ['status' => 500, 'message' => $con->error];

}
echo json_encode($data);
$con->close();
?>
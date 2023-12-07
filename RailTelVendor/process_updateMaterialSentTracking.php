<? include('config.php');

$id = $_POST['id'];
$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$challanNumber = $_POST['challanNumber'];
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

// Function to generate a unique filename
function generateUniqueFileName($originalFileName)
{
    $extension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    return uniqid() . '.' . $extension;
}

// Process the LR Copy image
if (isset($_FILES['lrCopy']) && $_FILES['lrCopy']['error'] === UPLOAD_ERR_OK) {
    $lrCopyName = generateUniqueFileName($_FILES['lrCopy']['name']);
    $lrCopyPath = $uploadDir . $lrCopyName;
    move_uploaded_file($_FILES['lrCopy']['tmp_name'], $lrCopyPath);
}

// Process the Delivery Challan image
if (isset($_FILES['deliveryChallan']) && $_FILES['deliveryChallan']['error'] === UPLOAD_ERR_OK) {
    $deliveryChallanName = generateUniqueFileName($_FILES['deliveryChallan']['name']);
    $deliveryChallanPath = $uploadDir . $deliveryChallanName;
    move_uploaded_file($_FILES['deliveryChallan']['tmp_name'], $deliveryChallanPath);
}


$sql = "INSERT INTO trackingDetailsUpdate (materialSendId,atmid, siteid, challanNumber, receiversName, receiversNumber, lrCopyPath, deliveryChallanPath,portal,status,receivedDate,receivedTime)
        VALUES ('$id','$atmid', '$siteid', '$challanNumber', '$receiversName', '$receiversNumber', '$lrCopyPath', '$deliveryChallanPath','Vendor',1,'$receivedDate','$receivedTime')";

if ($con->query($sql) === TRUE) {

    mysqli_query($con, "update material_send set isDelivered=1 where id='" . $id . "'");


    $vendorsql = mysqli_query($con, "Select * from material_send where id ='" . $id . "'");
    $vendorsqlResult = mysqli_fetch_assoc($vendorsql);
    $invID = $vendorsqlResult['invID'];
    $vendorId = $vendorsqlResult['vendorId'];

    $invSql = mysqli_query($con, "select * from inventory where id='" . $invID . "'");
    $invSqlResult = mysqli_fetch_assoc($invSql);
    $material = $invSqlResult['material'];
    $material_make = $invSqlResult['material_make'];
    $serial_no = $invSqlResult['serial_no'];
    $amount = $invSqlResult['amount'];
    $gst = $invSqlResult['gst'];
    $amount_witd_gst = $invSqlResult['amount_witd_gst'];

    mysqli_query($con, "insert into vendor(vendorId, material, material_make, model_no, serial_no,  amount, gst, amount_with_gst, 
    date_of_receiving, receiver_name,  created_at, created_by,  status, isSentToEngineer, engineerId, engineerName)
    values('" . $vendorId . "','" . $material . "','" . $material_make . "','" . $model_no . "','" . $serial_no . "',  '" . $amount . "', '" . $gst . "', '" . $amount_with_gst . "', 
    '" . $receivedDate . "', '" . $receiversName . "', '" . $datetime . "', '" . $userid . "',  1, 0, 0, '')
    ");




    $data = ['status' => 200, 'response' => 'Updated Succesfully'];
    echo json_encode($data);
    confirmMaterialReceive($siteid, $atmid, '');

} else {
    $data = ['status' => 500, 'response' => $con->error];
    echo json_encode($data);
}

$con->close();
?>
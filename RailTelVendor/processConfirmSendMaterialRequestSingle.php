<? include('config.php');

$serializedAttributes = $_POST['attribute'];
$serializedValues = $_POST['values'];
$serializedSerialNumbers = $_POST['serialNumbers'];

$attributes = unserialize($serializedAttributes);
$values = unserialize($serializedValues);
$serialNumbers = unserialize($serializedSerialNumbers);

$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$vendorId = $_POST['vendorId'];
$contactPersonName = $_POST['contactPersonName'];
$contactPersonNumber = $_POST['contactPersonNumber'];
$address = $_POST['address'];
$pod = $_POST['POD'];
$courier = $_POST['courier'];
$remark = $_POST['remark'];


$query = "INSERT INTO vendorMaterialSend (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ssissssss", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark);
$stmt->execute();
$stmt->close();

$materialSendId = $con->insert_id;
if (!empty($attributes) && !empty($values) && !empty($serialNumbers) && ($materialSendId>0)) {
    $query = "INSERT INTO vendorMaterialSendDetails (materialSendId, attribute, value, serialNumber)
     VALUES ('" . $materialSendId . "', '" . $attributes . "', '" . $values . "' ,'" . $serialNumbers . "')";
    if (mysqli_query($con, $query)) {
        mysqli_query($con, "update vendorinventory set status=1 where serial_no='" . $serialNumbers . "'");
        sendMaterialToEngineer($siteid, $atmid, '');
        $response = ['status' => '200', 'message' => 'Form data saved successfully'];

    }else{
        $response = ['status' => '500', 'message' => 'Error updating status in the Inventory'];
    }
}else{
    $response = ['status' => '500', 'message' => 'Error updating status in the Inventory'];
}


$con->close();
echo json_encode($response);

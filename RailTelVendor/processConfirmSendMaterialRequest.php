<? include('config.php');

$serializedAttributes = $_POST['attribute'];
$serializedValues = $_POST['values'];
$serializedSerialNumbers = $_POST['serialNumbers'];

$attributes = unserialize($serializedAttributes);
$values = unserialize($serializedValues);
$serialNumbers = unserialize($serializedSerialNumbers);

$materialSendIDParent = $_POST['materialSendID'];

$atmid = $_POST['atmid'];
$siteid = $_POST['siteid'];
$vendorId = $_POST['vendorId'];
$contactPersonName = $_POST['contactPersonName'];
$contactPersonNumber = $_POST['contactPersonNumber'];
$address = $_POST['address'];
$pod = $_POST['POD'];
$courier = $_POST['courier'];
$remark = $_POST['remark'];



$query = "INSERT INTO vendorMaterialSend (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark,materialSendId) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ssisssssss", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark,$materialSendIDParent);
$stmt->execute();
$stmt->close();

$materialSendId = $con->insert_id;

if (!empty($attributes) && !empty($values) && !empty($serialNumbers)) {
    $query = "INSERT INTO vendorMaterialSendDetails (materialSendId, attribute, value, serialNumber) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("isss", $materialSendId, $attribute, $value, $serialNumber);
    for ($i = 0; $i < count($attributes); $i++) {
        $attribute = $attributes[$i];
        $value = $values[$i];
        $serialNumber = $serialNumbers[$i];
        $stmt->execute();
            mysqli_query($con,"update vendorinventory set status=1 where serial_no='".$serialNumber."'") ; 
    }
    sendMaterialToEngineer($siteid,$atmid,'') ;
    $stmt->close();

}


$con->close();
$response = ['status' => '200', 'message' => 'Form data saved successfully'];
echo json_encode($response);

?>
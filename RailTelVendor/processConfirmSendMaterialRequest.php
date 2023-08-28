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

$data = [
    'atmid' => $atmid,
    'siteid' => $siteid,
    'vendorId' => $vendorId,
    'contactPersonName' => $contactPersonName,
    'contactPersonNumber' => $contactPersonNumber,
    'pod' => $pod,
    'courier' => $courier,
    'remark' => $remark,
    'address' => $address,
    'attribute' => $attributes,
    'values' => $values,
    'serialNumbers' => $serialNumbers
];

$query = "INSERT INTO vendorMaterialSend (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ssissssss", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark);
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
    }
    sendMaterialToEngineer($siteid,$atmid,'') ;
    $stmt->close();
}


$con->close();
$response = ['status' => '200', 'message' => 'Form data saved successfully'];
echo json_encode($response);

?>
<?php include('config.php');

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

// Prepare and execute the query to save the data into the database
$query = "INSERT INTO material_send (atmid, siteid, vendorId, contactPersonName, contactPersonNumber, address, pod, courier, remark) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $con->prepare($query);
$stmt->bind_param("ssissssss", $atmid, $siteid, $vendorId, $contactPersonName, $contactPersonNumber, $address, $pod, $courier, $remark);
$stmt->execute();
$stmt->close();

$materialSendId = $con->insert_id;

mysqli_query($con,"update material_requests set status='Material Sent' where siteid='".$siteid."' and isProject=1");


if (!empty($attributes) && !empty($values) && !empty($serialNumbers)) {
    $query = "INSERT INTO material_send_details (materialSendId, attribute, value, serialNumber) VALUES (?, ?, ?, ?)";
    $stmt = $con->prepare($query);
    $stmt->bind_param("isss", $materialSendId, $attribute, $value, $serialNumber);
    for ($i = 0; $i < count($attributes); $i++) {
        $attribute = $attributes[$i];
        $value = $values[$i];
        $serialNumber = $serialNumbers[$i];
        $stmt->execute();
    }
    $stmt->close();
}

// Update the status in the Inventory table
if (!empty($serialNumbers)) {
    $status = 'New Status'; // Replace 'New Status' with the appropriate status value

    foreach ($serialNumbers as $serialNumber) {
        $sql = "UPDATE Inventory SET status = '$status' WHERE serial_no = '$serialNumber'";
        $result = mysqli_query($con, $sql);

        if (!$result) {
            // Error occurred while updating status
            $response = ['status' => '500', 'message' => 'Error updating status in the Inventory table'];
            echo json_encode($response);
            exit;
        }
    }
}

// Close the database connection
$con->close();

$response = ['status' => '200', 'message' => 'Form data saved successfully'];
echo json_encode($response);

<?php
include('../config.php');

$response = array();
$response['openCall'] = false;

if (isset($_POST['atmid'])) {
    $atmid = $_POST['atmid'];
    
    // Check if there is an open call for the given atmid
    $openCallQuery = "SELECT COUNT(*) as open_calls FROM mis WHERE atmid = '".$atmid."' AND status = 'open'";
    $openCallResult = mysqli_query($con, $openCallQuery);
    $openCallData = mysqli_fetch_assoc($openCallResult);
    $openCalls = $openCallData['open_calls'];

    if ($openCalls > 0) {
        $response['openCall'] = true;
    }
}

// Output response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>

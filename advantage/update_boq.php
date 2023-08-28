<?php include('config.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $count = $_POST['count'];
    $status = $_POST['status'];
    $value = $_POST['value'];

    $sql = "UPDATE boq SET value='$value', count = '$count', status = '$status' WHERE id = $id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        $response = array('status' => 'success', 'message' => 'BOQ record updated successfully');
        echo json_encode($response);
    } else {
        $response = array('status' => 'error', 'message' => 'Failed to update BOQ record');
        echo json_encode($response);
    }
}
?>

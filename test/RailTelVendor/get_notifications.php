<?php
include('config.php');

$vendorId = 2;
$sql = "SELECT * FROM tasks WHERE vendor_id = $vendorId ORDER BY assigned_date DESC";
$result = mysqli_query($con, $sql);

$notifications = array(); // Create an array to hold the task names

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $notifications[] = $row['task_name']; // Add each task name to the $notifications array
    }
}

// Convert the $notifications array to JSON format and send it as the response
header('Content-Type: application/json');
echo json_encode($notifications);
?>

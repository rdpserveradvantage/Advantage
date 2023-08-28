<?php include('config.php');

    $taskName = $_POST['taskName'];
    $vendorId = $_POST['vendorId'];

    $sql = "INSERT INTO tasks (task_name, vendor_id, assigned_date) VALUES ('$taskName', '$vendorId', NOW())";

    if (mysqli_query($con, $sql)) {
        echo "Task assigned successfully!";
    } else {
        echo "Error: " . mysqli_error($con);
    }

    // Close the database connection
    mysqli_close($con);

?>

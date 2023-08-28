<?php
// log_functions.php

function log_change($table_name, $record_id, $action, $changed_data) {

global $con ; 
    // Sanitize data before using it in a query to prevent SQL injection
    $table_name = mysqli_real_escape_string($con, $table_name);
    $record_id = (int) $record_id;
    $action = mysqli_real_escape_string($con, $action);
    $changed_data = json_encode($changed_data);

    // Insert the log entry into the log_table
    $query = "INSERT INTO log_table (table_name, record_id, action, changed_data) 
              VALUES ('$table_name', $record_id, '$action', '$changed_data')";
    mysqli_query($con, $query);
}
?>

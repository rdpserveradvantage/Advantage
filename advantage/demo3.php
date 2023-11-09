<?php include('config.php');
// Get the user ID and table name from the AJAX request
$user_id = $userid;
$table_name = $_GET['tableId'];

// Query to retrieve user preferences for the specified user and table
echo $query = "SELECT column_preferences FROM user_table_preferences WHERE user_id = '$user_id' AND table_name = '$table_name'";

$result = $con->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $selectedColumns = $row['column_preferences'];
    echo $selectedColumns;
} else {
    // If no preferences are found, send an empty string as a response
    echo '';
}

// Close the database connection
$con->close();

<?php
include('config.php'); // Include your database connection configuration

var_dump($_REQUEST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user ID, table name, and selected columns from the POST request
    $user_id = $userid ; 
    $table_name = $_POST['tableId'];
    $selected_columns = $_POST['selectedColumns'];

    // Check if the user already has preferences for the specified table
    $existing_preferences_query = "SELECT id FROM user_table_preferences WHERE user_id = ? AND table_name = ?";
    
    $stmt = $con->prepare($existing_preferences_query);
    $stmt->bind_param('ss', $user_id, $table_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        // User preferences already exist, so update them
        echo 
        $update_preferences_query = "UPDATE user_table_preferences SET column_preferences = '".$selected_columns."' WHERE user_id = '".$userid."' AND table_name = '".$table_name."'";

        mysqli_query($con,$update_preferences_query);
    } else {
        // User preferences don't exist, so insert a new record
        echo $insert_preferences_query = "INSERT INTO user_table_preferences (user_id, table_name, column_preferences) VALUES
        ('".$userid."','".$table_name."','".$selected_columns."')";
        mysqli_query($con,$insert_preferences_query);

    }

    // Execute the query to either update or insert preferences
    if ($stmt->execute()) {
        echo "Preferences saved successfully!";
    } else {
        http_response_code(500); // Internal Server Error
        echo "Error saving preferences.";
    }

    // Close the database connection
    $stmt->close();
    $con->close();
} else {
    http_response_code(400); // Bad Request
    echo "Invalid request.";
}
?>

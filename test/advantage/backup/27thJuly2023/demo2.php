<?php include('config.php');


function getColumnsWithValues($tableName, $id) {


    global $con ; 
    
    // Check connection
    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }

    // Prepare the query to get all columns with values for the given ID
    $sql = "SELECT * FROM " . $tableName . " WHERE id = " . $id;

    $rowData = array();

    // Execute the query
    $result = $con->query($sql);

    // Fetch row data and store them in an array
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        foreach ($row as $columnName => $columnValue) {
            $rowData[$columnName] = $columnValue;
        }
    }

    // Close the connection
    $con->close();

    // Return the row data as JSON
    return json_encode($rowData);
}

// Usage example:
$tableName = "sites";
$id = 1;
$resultJson = getColumnsWithValues($tableName, $id);

// Output the JSON result
echo $resultJson;


return ; 


// Get all tables in the database
$tables = [];
$tablesQuery = mysqli_query($con, "SHOW TABLES");
while ($row = mysqli_fetch_array($tablesQuery)) {
    $tables[] = $row[0];
}

// Array to store trigger creation statements
$trigger_creation_statements = [];

// Loop through each table and create trigger statements
foreach ($tables as $table) {
    $columns = [];
    $columnsQuery = mysqli_query($con, "SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='$database' AND TABLE_NAME='$table'");
    while ($row = mysqli_fetch_array($columnsQuery)) {
        $columns[] = $row[0];
    }

    // Generate the trigger creation statements for insert, update, and delete operations
    $trigger = "CREATE TRIGGER after_insert_update_trigger_$table
    AFTER INSERT ON $table
    FOR EACH ROW
    BEGIN
        INSERT INTO log_after (table_name, record_id, current_data)
        VALUES ('$table', NEW.id, '" . json_encode(array_combine($columns, array_map(function ($col) {
        return 'NEW.' . $col;
    }, $columns))) . "')
        ON DUPLICATE KEY UPDATE current_data = '" . json_encode(array_combine($columns, array_map(function ($col) {
        return 'NEW.' . $col;
    }, $columns))) . "';
    END;";

    $trigger_creation_statements[] = $trigger;
}

// Loop through each trigger creation statement and execute it
foreach ($trigger_creation_statements as $statement) {
    $result = mysqli_query($con, $statement);

    if ($result) {
        echo "Trigger created successfully: $statement<br>";
    } else {
        echo "Error creating trigger: " . mysqli_error($con) . "<br>";
    }
}

// Close the database connection
mysqli_close($con);
?>

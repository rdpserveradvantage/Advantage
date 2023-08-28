<?php
// header('Content-Type: text/event-stream');
// header('Cache-Control: no-cache');


include('config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

function fetchData() {
    global $con;
    
    // Create a prepared statement
    $stmt = $con->prepare("SELECT id as ID, name as Username, uname as Email FROM mis_loginusers");
    $stmt->execute();

    // Bind the result to variables
    $stmt->bind_result($id, $username, $email);

    // Fetch the data into an associative array
    $result = array();
    while ($stmt->fetch()) {
        $result[] = array(
            'ID' => $id,
            'Username' => $username,
            'Email' => $email
        );
    }

    return $result;
}

// Send initial data to the client
echo 'data: ' . json_encode(fetchData()) . "\n\n";
flush();

// Infinite loop to check for database updates and send to the client
while (true) {
    sleep(5); // Adjust the polling interval as needed

    $currentData = fetchData();
    $previousData = isset($result) ? $result : null;

    if ($currentData !== $previousData) {
        echo 'data: ' . json_encode($currentData) . "\n\n";
        flush();
    }

    $result = $currentData;
}
?>
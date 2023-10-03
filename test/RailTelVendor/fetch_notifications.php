<? include('config.php');

$recipientType = ''; // Replace with the actual recipient type (e.g., 'admin', 'vendor')
$notifications = fetchNotificationsAndCount($recipientType, $userid);
header('Content-Type: application/json');

// Return the JSON-encoded notifications array
echo json_encode( $notifications );
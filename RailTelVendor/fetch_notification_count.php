<?php include('config.php');


$recipientType = ''; 

$notificationData = fetchNotificationsAndCount($recipientType, $userid);
header('Content-Type: application/json');

echo json_encode(['notification_count' => $notificationData['notification_count']]);
?>

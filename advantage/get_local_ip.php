<?php
// This script responds with the client's local IP address.
header('Content-Type: application/json');

// The client-side JavaScript will send an AJAX request to this script.
// The response will contain the local IP address detected by JavaScript.
echo json_encode(array('local_ip' => ''));
?>

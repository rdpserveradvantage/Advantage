<?php
// Client configuration
$serverHost = '127.0.0.1'; // or 'localhost'
$serverPort = 8080;

// Create a TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die('Error: Unable to create socket.');
}

// Connect to the server
if (!socket_connect($socket, $serverHost, $serverPort)) {
    die('Error: Unable to connect to the server.');
}

// Send a message to the server
$message = "Hello, server!";
socket_write($socket, $message, strlen($message));

// Receive the response from the server
$response = socket_read($socket, 1024);
echo "Response from server: $response\n";

// Close the socket
socket_close($socket);

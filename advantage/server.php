<?php

phpinfo();
// Server configuration
$host = 'localhost';
$port = 8080;

// Create a TCP/IP socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
if ($socket === false) {
    die('Error: Unable to create socket.');
}

// Bind the socket to the address and port
if (!socket_bind($socket, $host, $port)) {
    die('Error: Unable to bind socket to ' . $host . ':' . $port);
}

// Listen for incoming connections
if (!socket_listen($socket)) {
    die('Error: Unable to listen on the socket.');
}

echo "Server is listening on $host:$port\n";

// Accept incoming connections and handle them
while (true) {
    $clientSocket = socket_accept($socket);
    if ($clientSocket) {
        // Read data from the client
        $message = socket_read($clientSocket, 1024);
        echo "Received message from client: $message\n";

        // Send a response back to the client
        $response = "Server received: $message";
        socket_write($clientSocket, $response, strlen($response));

        // Close the client socket
        socket_close($clientSocket);
    }
}

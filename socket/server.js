const express = require('express');
const http = require('http');
const WebSocket = require('ws');
const mysql = require('mysql'); // Import the MySQL library

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

// Store connected clients
const clients = new Set();

// Function to broadcast notifications to all connected clients
function broadcastNotifications(notifications) {
    for (const client of clients) {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(notifications));
        }
    }
}

app.use(express.json()); // Parse JSON request bodies

// Create a MySQL connection
const dbConnection = mysql.createConnection({
    host: '10.63.21.6',
    user: 'advantage',
    password: 'qwerty121',
    database: 'sarmicrosystems_advantage',
});

// Connect to the MySQL database
dbConnection.connect((err) => {
    if (err) {
        console.error('Error connecting to MySQL:', err);
    } else {
        console.log('Connected to MySQL');
    }
});

// API endpoint to fetch and send notifications from MySQL
app.get('/api/notifications', (req, res) => {
    // Write a SQL query to fetch notifications from your MySQL table
    const query = 'SELECT user, message, timestamp FROM notifications';

    // Execute the SQL query
    dbConnection.query(query, (err, rows) => {
        if (err) {
            console.error('Error fetching notifications:', err);
            res.status(500).json({ error: 'Internal server error' });
        } else {
            // Format the retrieved data as notifications
            const notifications = rows.map((row) => ({
                user: row.user,
                message: row.message,
                time: row.timestamp.toLocaleTimeString(),
            }));

            // Broadcast the notifications to all connected clients
            broadcastNotifications(notifications);

            res.status(200).json({ success: true });
        }
    });
});

wss.on('connection', (ws) => {
    console.log('Client connected');

    // Add the client to the set of connected clients
    clients.add(ws);

    // Handle WebSocket disconnections
    ws.on('close', () => {
        console.log('Client disconnected');
        // Remove the client from the set of connected clients
        clients.delete(ws);
    });
});

// Start the server
const PORT = process.env.PORT || 8080;
server.listen(PORT, () => {
    console.log(`WebSocket server is running on port ${PORT}`);
});

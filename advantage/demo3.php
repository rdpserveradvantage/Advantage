<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>
</head>

<body>
  <h1>Real-Time Notifications</h1>

  <!-- Notifications container -->
  <ul id="notificationList"></ul>

<!-- JavaScript to handle WebSocket connection and notifications -->
<script>
    const notificationList = document.getElementById('notificationList');

    // WebSocket connection
    const socket = new WebSocket('ws://localhost:8080'); // Change to your WebSocket server URL

    // Listen for incoming WebSocket messages (notifications)
    socket.addEventListener('message', function (event) {
      const notifications = JSON.parse(event.data);
      addNotifications(notifications); // Add the new notifications to the list
    });

    // Function to add multiple notifications to the list
    function addNotifications(notifications) {
      notifications.forEach((data) => {
        const notificationItem = document.createElement('li');
        notificationItem.innerHTML = `
            <strong>${data.user}</strong>: ${data.message} (${data.time})
        `;
        notificationList.appendChild(notificationItem);
      });
    }

</script>

</body>

</html>
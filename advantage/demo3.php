<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications</title>
</head>

<body>
  <h1>Real-Time Notifications</h1>
  <ul id="notificationList"></ul>
  <script>
    const notificationList = document.getElementById('notificationList');
    const socket = new WebSocket('ws://localhost:8080');
    socket.addEventListener('message', function(event) {
      const notifications = JSON.parse(event.data);
      console.log(notifications)
      addNotifications(notifications);
    });

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
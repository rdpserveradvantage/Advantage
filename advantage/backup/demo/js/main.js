// main.js
if ('Notification' in window) {
  // Request permission to show notifications
  Notification.requestPermission().then(function (permission) {
    if (permission === 'granted') {
      console.log('Notification permission granted.');
    } else {
      console.log('Notification permission denied.');
    }
  });

  // Handle the click event on the notification
  function handleNotificationClick() {
    // Do something when the user clicks on the notification
    console.log('Notification clicked.');
  }

  // Add event listener to the submit button
  document.getElementById('submitSealverification').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default form submission behavior

    if (Notification.permission === 'granted') {
      const options = {
        body: 'This is the notification body text.',
        icon: 'images/image-11.jpg', // Replace with the path to your icon image
      };

      const notification = new Notification('Notification Title', options);
      notification.onclick = handleNotificationClick;
    } else if (Notification.permission === 'denied') {
      console.log('Notification permission denied. You can change this in your browser settings.');
    } else {
      console.log('Notification permission has not been granted yet. You can request permission.');
    }
  });
}

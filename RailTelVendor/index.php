<? include('header.php'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<link rel="stylesheet" type="text/css" href="files/assets/pages/notification/notification.css">

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                            <span> Clarity - Project</span>
                        </h6>
                        <br>
                    <div class="row" id="part2"></div>
                    <div class="row" id="part3"></div>
                    <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                            <span>Inventory</span>
                        </h6>
                        <br>
                    <div class="row" id="part4"></div>
                    <!-- <div class="card">
                        <div class="card-block"> -->
                            <!--<div class="row" id="part1"></div>-->



                            <!-- <div id="notificationContainer"></div> -->

                            <?

                            // $notifications = fetchNotifications($recipientType, $userid) ; 
                            // // $notifications = fetchNotifications($recipientType, $recipientId);

                            // var_dump($notifications);

                            // foreach ($notifications as $notification) {
                            //     echo "Notification ID: " . $notification['notification_id'] . "<br>";
                            //     echo "Sender Type: " . $notification['sender_type'] . "<br>";
                            //     echo "Message: " . $notification['message'] . "<br>";
                            //     echo "Created At: " . $notification['created_at'] . "<br>";
                            //     echo "-----------------------------------<br>";
                            // }


                            ?>


                        <!-- </div> -->
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        // Load content for part2 asynchronously
        $.ajax({
            url: 'part2Dashboard.php',
            method: 'GET',
            success: function(response) {
                $('#part2').html(response);
            },
            error: function() {
                $('#part2').html('Error loading part2 content.');
            }
        });

        // Load content for part3 asynchronously
        $.ajax({
            url: 'part3Dashboard.php',
            method: 'GET',
            success: function(response) {
                $('#part3').html(response);
            },
            error: function() {
                $('#part3').html('Error loading part3 content.');
            }
        });
        // Load content for part3 asynchronously
        $.ajax({
            url: 'part4Dashboard.php',
            method: 'GET',
            success: function(response) {
                $('#part4').html(response);
            },
            error: function() {
                $('#part4').html('Error loading part3 content.');
            }
        });
    });




















    // function notify(message, type) {

    //     console.log(message);
    //     console.log(type);

    //     const notificationContainer = $('#notificationContainer');
    //     const notification = $('<div class="notification">').text(message);

    //     notification.addClass(type);

    //     notificationContainer.append(notification);

    //     setTimeout(function() {
    //         notification.fadeOut(function() {
    //             notification.remove();
    //         });
    //     }, 2500);
    // }



    function displayNotifications() {
        $.ajax({
            url: 'get_notifications.php', // Replace with your PHP script to fetch notifications
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                data.forEach(function(notification) {
                    notify(notification, 'success');
                });
            },
            error: function(xhr, status, error) {
                console.error('Error fetching notifications:', error);
            }
        });
    }

    // Call the displayNotifications function when the page loads or when the vendor logs in
    $(document).ready(function() {
        displayNotifications();
    });
</script>
<? include('footer.php'); ?>

<script type="text/javascript" src="files/assets/js/bootstrap-growl.min.js"></script>
<script type="text/javascript" src="files/assets/pages/notification/notification.js"></script>
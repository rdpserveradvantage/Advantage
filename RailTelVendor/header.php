<?php
include('config.php');
ini_set('post_max_size', '64M');
ini_set('upload_max_filesize', '64M');

$token = $_SESSION['VENDOR_token'];
$RailTelVendorSite = $_SESSION['VENDOR_RailTelVendorSite'];
$site = $_SESSION['VENDOR_site'];

if (isset($_REQUEST['advantagetoken']) && !empty($_REQUEST['advantagetoken'])) {
    $advantagetoken = $_REQUEST['advantagetoken'];
    $RailTailVendorID = $_REQUEST['vendor'];

    $_SESSION['VENDOR_advantagetoken'] = $advantagetoken;
    $_SESSION['VENDOR_RailTailVendorID'] = $RailTailVendorID;
} else if (isset($_SESSION['VENDOR_advantagetoken']) && !empty($_SESSION['VENDOR_advantagetoken'])) {
    $advantagetoken = $_SESSION['VENDOR_advantagetoken'];
    $RailTailVendorID = $_SESSION['VENDOR_RailTailVendorID'];
} else {
    // if (!function_exists('verifyToken')) {
    //     function verifyToken($token){
    //         global $con; 

    //         $sql = mysqli_query($con,"select * from vendorUsers where token='".$token."' and user_status=1");
    //             if($sql_result = mysqli_fetch_assoc($sql)){
    //                 return 1 ; 

    //             }else{
    //                 return 0;
    //             }    
    //     }    
    // }    
    // echo $advantageInventory ; 

    // var_dump($_SESSION);

    if (
        !$_SESSION['VENDOR_username'] || empty($_SESSION['VENDOR_username'])
        // verifyToken($token)!=1 
        // || $site!='RailTelVendorSite'
    ) {
        header('Location: login.php');
        exit;
    }
}



?>
<!DOCTYPE html>
<html lang="en" style="text-transform: uppercase;">

<head>
    <title> RailTel - <?= $RailTailVendorName ; ?> </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.9">
    <!--<meta name="viewport" content="width=device-width, initial-scale=0.8, user-scalable=0, minimal-ui">-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/1601680170_capture.jpg" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css">
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <script src="select2/dist/js/select2.min.js" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css">
    <!--<link rel="stylesheet" type="text/css" href="assets/line.css">-->
    <!--<link rel="stylesheet" type="text/css" href="assets/all.min.css">-->
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css" type="text/css">
    </link>
    <link rel="stylesheet" href="https://preview.pichforest.com/dashonic/layouts/assets/css/app.min.css" type="text/css">
    </link>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <link href="./fa/css/fontawesome.css" rel="stylesheet">
    <link href="./fa/css/brands.css" rel="stylesheet">
    <link href="./fa/css/solid.css" rel="stylesheet">





</head>




<body>



    <style>
        .loader-block {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }

        .loading-container {
            width: 100%;
            max-width: 520px;
            text-align: center;
            color: #fff;
            position: relative;
            margin: 0 32px;
        }

        .loading-container:before {
            content: "";
            position: absolute;
            width: 100%;
            height: 3px;
            background-color: #fff;
            bottom: 0;
            left: 0;
            border-radius: 10px;
            -webkit-animation: movingLine 2.4s infinite ease-in-out;
            animation: movingLine 2.4s infinite ease-in-out;
        }

        @-webkit-keyframes movingLine {
            0% {
                opacity: 0;
                width: 0;
            }

            33.3%,
            66% {
                opacity: 0.8;
                width: 100%;
            }

            85% {
                width: 0;
                left: initial;
                right: 0;
                opacity: 1;
            }

            100% {
                opacity: 0;
                width: 0;
            }
        }

        @keyframes movingLine {
            0% {
                opacity: 0;
                width: 0;
            }

            33.3%,
            66% {
                opacity: 0.8;
                width: 100%;
            }

            85% {
                width: 0;
                left: initial;
                right: 0;
                opacity: 1;
            }

            100% {
                opacity: 0;
                width: 0;
            }
        }

        .loading-text {
            font-size: 5vw;
            line-height: 64px;
            letter-spacing: 10px;
            margin-bottom: 32px;
            display: flex;
            justify-content: space-evenly;
        }

        .loading-text span {
            -webkit-animation: moveLetters 2.4s infinite ease-in-out;
            animation: moveLetters 2.4s infinite ease-in-out;
            transform: translatex(0);
            position: relative;
            display: inline-block;
            opacity: 0;
            text-shadow: 0px 2px 10px rgba(46, 74, 81, 0.3);
        }

        .loading-text span:nth-child(1) {
            -webkit-animation-delay: 0.1s;
            animation-delay: 0.1s;
        }

        .loading-text span:nth-child(2) {
            -webkit-animation-delay: 0.2s;
            animation-delay: 0.2s;
        }

        .loading-text span:nth-child(3) {
            -webkit-animation-delay: 0.3s;
            animation-delay: 0.3s;
        }

        .loading-text span:nth-child(4) {
            -webkit-animation-delay: 0.4s;
            animation-delay: 0.4s;
        }

        .loading-text span:nth-child(5) {
            -webkit-animation-delay: 0.5s;
            animation-delay: 0.5s;
        }

        .loading-text span:nth-child(6) {
            -webkit-animation-delay: 0.6s;
            animation-delay: 0.6s;
        }

        .loading-text span:nth-child(7) {
            -webkit-animation-delay: 0.7s;
            animation-delay: 0.7s;
        }

        @-webkit-keyframes moveLetters {
            0% {
                transform: translateX(-15vw);
                opacity: 0;
            }

            33.3%,
            66% {
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                transform: translateX(15vw);
                opacity: 0;
            }
        }

        @keyframes moveLetters {
            0% {
                transform: translateX(-15vw);
                opacity: 0;
            }

            33.3%,
            66% {
                transform: translateX(0);
                opacity: 1;
            }

            100% {
                transform: translateX(15vw);
                opacity: 0;
            }
        }

        .socials {
            position: fixed;
            bottom: 16px;
            right: 16px;
            display: flex;
            align-items: center;
        }

        .social-link {
            color: #fff;
            display: flex;
            align-items: center;
            cursor: pointer;
            text-decoration: none;
            margin-right: 12px;
        }


        .loader-block {
            width: 100%;
            height: 140vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: radial-gradient(circle farthest-corner at 10% 20%, #00989b 0.1%, #005e78 94.2%);
            background-size: 100%;
            font-family: "Montserrat", sans-serif;
            overflow: hidden;
        }
    </style>








    <div class="loader-block">
        <div class="loading-container">
            <div class="loading-text">
                <span>L</span>
                <span>O</span>
                <span>A</span>
                <span>D</span>
                <span>I</span>
                <span>N</span>
                <span>G</span>
            </div>
        </div>




        <!--<svg id="loader2" viewbox="0 0 100 100">-->
        <!--<circle id="circle-loader2" cx="50" cy="50" r="45"></circle>-->
        <!--</svg>-->
    </div>


    <style>
        .logo_img {
            width: auto;
            height: 50px;
        }

        .pcoded .pcoded-header .navbar-logo[logo-theme="theme1"] {
            background-color: white;
        }

        .pcoded .pcoded-header[header-theme="theme1"] .navbar-logo a {
            color: black;
        }
    </style>
    <button id="click" style="display:none;"></button>

    <div id="pcoded" class="pcoded" nav-type="st5">
        <div class="pcoded-overlay-box"></div>
        <div class="pcoded-container navbar-wrapper">

            <nav class="navbar header-navbar pcoded-header">
                <div class="navbar-wrapper">

                    <div class="navbar-logo">
                        <a class="mobile-menu" id="mobile-collapse" href="#!">
                            <i class="feather icon-menu icon-toggle-right"></i>
                        </a>
                        <a href="index.php" style="margin-left: 16px;">
                            <img src="assets/1601680170_capture.jpg" class="logo_img" />

                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>


                    <div class="navbar-container">
                        <ul class="nav-left" style="background: #01a9ac;">
                            <li class="header-search strong" style="font-size: 17px; color: white;">
                                Vendor Portal
                            </li>
                        </ul>



                        <ul class="nav-right">
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                        <i class="feather icon-bell"></i>
                                        <span class="badge bg-c-pink" id="notificationCount">
                                            <?php echo isset($notificationCount) ? $notificationCount : 0; ?>
                                        </span>

                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        <!-- FetchNotifications function automatically updates the notifications here -->
                                    </ul>
                                </div>
                            </li>



                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">

                                        <span class="strong"><? echo ucwords($_SESSION['VENDOR_username']); ?></span>

                                    </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>

            <!-- Sidebar chat start -->
            <div id="sidebar" class="users p-chat-user showChat">
                <div class="had-container">
                    <div class="card card_main p-fixed users-main">
                        <div class="user-box">
                            <div class="chat-inner-header">
                                <div class="back_chatBox">
                                    <div class="right-icon-control">
                                        <input type="text" class="form-control  search-text" placeholder="Search Friend" id="search-friends">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box" data-id="1" data-status="online" data-username="Josephin Doe" data-toggle="tooltip" data-placement="left" title="Josephin Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius img-radius" src="" alt="Generic placeholder image ">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="2" data-status="online" data-username="Lary Doe" data-toggle="tooltip" data-placement="left" title="Lary Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice" data-toggle="tooltip" data-placement="left" title="Alice">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia" data-toggle="tooltip" data-placement="left" title="Alia">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen" data-toggle="tooltip" data-placement="left" title="Suzen">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src="" alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Suzen</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat start-->
            <div class="showChat_inner">
                <div class="media chat-inner-header">
                    <a class="back_chatBox">
                        <i class="feather icon-chevron-left"></i> Josephin Doe
                    </a>
                </div>
                <div class="media chat-messages">
                    <a class="media-left photo-table" href="#!">
                        <img class="media-object img-radius img-radius m-t-5" src="" alt="Generic placeholder image">
                    </a>
                    <div class="media-body chat-menu-content">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                </div>
                <div class="media chat-messages">
                    <div class="media-body chat-menu-reply">
                        <div class="">
                            <p class="chat-cont">I'm just looking around. Will you tell me something about yourself?</p>
                            <p class="chat-time">8:20 a.m.</p>
                        </div>
                    </div>
                    <div class="media-right photo-table">
                        <a href="#!">
                            <img class="media-object img-radius img-radius m-t-5" src="" alt="Generic placeholder image">
                        </a>
                    </div>
                </div>
                <div class="chat-reply-box p-b-20">
                    <div class="right-icon-control">
                        <input type="text" class="form-control search-text" placeholder="Share Your Thoughts">
                        <div class="form-icon">
                            <i class="feather icon-navigation"></i>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sidebar inner chat end-->
            <div class="pcoded-main-container">
                <div class="pcoded-wrapper">
                    <style>
                        label {
                            font-weight: 600;
                        }

                        body {
                            zoom: 0.8;
                        }

                        .highlight:required:invalid {
                            border: 2px solid red;
                        }

                        .highlight:required:invalid+label {
                            color: red;
                            font-weight: bold;
                        }

                        /*@font-face {*/
                        /*    font-family: oswald;*/
                        /*    src: url(fonts/Exo2-VariableFont_wght.ttf);*/
                        /*    font-display: block;*/
                        /*}*/
                        /*body{*/
                        /*        font-family: oswald;*/
                        /*}*/
                    </style>


                    <? include('nav.php'); ?>




                    <script>
                        // let previousNotificationCount = 0;
                        // let isNewNotification = false;


                        // function playNotificationSound() {
                        //     const notificationSound = new Audio('assets/Notification.mp31');
                        //     notificationSound.play();
                        //     isNewNotification = false; // Reset the flag after playing the sound
                        // }


                        // function fetchNotificationCount() {
                        //     fetch('fetch_notification_count.php') // 'fetch_notification_count.php' ko replace karein actual file path se
                        //         .then(response => response.json())
                        //         .then(data => {
                        //             const notificationCountElement = document.getElementById('notificationCount');
                        //             const currentNotificationCount = parseInt(data.notification_count);

                        //              // Compare current count with previous count
                        //             if (currentNotificationCount > previousNotificationCount) {
                        //                 // New notifications have arrived, play the notification sound
                        //                 isNewNotification = true;
                        //             playNotificationSound();

                        //             }


                        //             notificationCountElement.textContent = data.notification_count;
                        //             console.log(currentNotificationCount);
                        //             previousNotificationCount = currentNotificationCount;

                        //         })
                        //         .catch(error => {
                        //             console.error('Error fetching notification count:', error);
                        //         });
                        // }



                        // function updateNotifications() {
                        //     fetchNotificationCount();
                        //     fetchNotifications();


                        // }

                        // function initNotificationSound() {
                        //     // Add an event listener to trigger the notification sound on user interaction.
                        //     document.getElementById('playNotificationButton').addEventListener('click', () => {
                        //         if (isNewNotification) {
                        //             playNotificationSound();
                        //         }
                        //     });
                        // }



                        // // Run the updateNotifications function every 3 seconds (adjust as needed)
                        // setInterval(updateNotifications, 3000);

                        // document.addEventListener('DOMContentLoaded', initNotificationSound);

                        // // script.js
                        // function fetchNotifications() {
                        //     fetch('fetch_notifications.php') // 'fetch_notifications.php' ko replace karein actual file path se
                        //         .then(response => response.json())
                        //         .then(data => {
                        //             // Process the fetched notifications
                        //             const notificationView = document.querySelector('.show-notification');
                        //             notificationView.innerHTML = ''; // Purani notifications ko clear karein

                        //             if (data.notifications.length > 0) {

                        //                 // Update the notification section with the latest notifications
                        //                 data.notifications.forEach(notification => {
                        //                     const notificationItem = document.createElement('li');
                        //                     notificationItem.innerHTML = `
                        //                         <a href="#">
                        //                             <div class="media">
                        //                                 <div class="media-body">
                        //                                     <h5 class="notification-user">${notification.message}</h5>
                        //                                     <p class="notification-msg">Received at: ${notification.created_at}</p>
                        //                                 </div>
                        //                             </div>
                        //                         </a>
                        //                     `;
                        //                     notificationView.appendChild(notificationItem);
                        //                 });
                        //             }
                        //         })
                        //         .catch(error => {
                        //             console.error('Error fetching notifications:', error);
                        //         });
                        // }

                        // // Run the fetchNotifications function every 3 seconds (adjust as needed)
                        // setInterval(fetchNotifications, 3000);



                        window.addEventListener('load', function() {
                            var loader = document.querySelector('.loader-block');
                            var pcoded = document.querySelector('#pcoded');

                            setTimeout(function() {
                                loader.style.display = 'none';
                                pcoded.style.visibility = 'visible';
                            }, 2500); // 3000 milliseconds = 3 seconds
                        });
                        var mobileMenu = document.getElementById('mobile-collapse');
                        var iconElement = mobileMenu.querySelector('i');

                        mobileMenu.addEventListener('click', function() {
                            iconElement.classList.toggle('icon-toggle-right');
                            iconElement.classList.toggle('icon-toggle-left');
                        });
                    </script>
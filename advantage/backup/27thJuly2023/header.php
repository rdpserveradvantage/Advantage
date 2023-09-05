<?php include('config.php');
  
$token = $_SESSION['advantagetoken'] ;

if (!function_exists('verifyToken')) {
    function verifyToken($token){
        global $con; 
    
        $sql = mysqli_query($con,"select * from mis_loginusers where token='".$token."' and user_status=1");
            if($sql_result = mysqli_fetch_assoc($sql)){
                return 1 ; 
        
            }else{
                return 0;
            }    
    }    
}    


if(verifyToken($token)!=1){

    header('Location: login.php');
    exit;
}



?>
<!DOCTYPE html>
<html lang="en" style="text-transform: uppercase;">

<head>
    <meta property="og:title" content=" AdvantageSB Communications Private Limited ">
    <meta property="og:description" content="Advantage provides world-class connectivity solution with the latest generation of 4G LTE & 5G technology enabling exceptional throughput and assured uptime of 99.5% at the last mile">
    <meta property="og:image" content="http://advantage.advantagesb.com/assets/advantage.png">
    <meta property="og:url" content="http://advantage.advantagesb.com/">
    <meta property="og:type" content="Advantage CRM">
    
    
    <title> Advantage </title>
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


    
    
<style>
    body {
      zoom: 0.8;
    }

    .loader-block {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
        }
             /* Hide the #pcoded element when the loader is visible */
        #pcoded {
            visibility: hidden;
        }

        /* Show the #pcoded element once the loader is hidden */
        .loader-block + #pcoded {
            visibility: visible;
        }
</style>
</head>



<body>
    
<div class="loader-block">
<svg id="loader2" viewbox="0 0 100 100">
<circle id="circle-loader2" cx="50" cy="50" r="45"></circle>
</svg>
</div>


    <style>
         .logo_img{
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
                            <img src="assets/1601680170_capture.jpg"  class="logo_img"/>    
                            
                        </a>
                        <a class="mobile-options">
                            <i class="feather icon-more-horizontal"></i>
                        </a>
                    </div>
                    

                    <div class="navbar-container">
                        
                        
                        <ul class="nav-right">
                            <li><a href="demo.php">Profile</a></li>
                            <li class="header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                    <i class="feather icon-bell"></i>
                                    <span class="badge bg-c-pink"><? echo $notification_count; ?></span>
                                    </div>
                                    <ul class="show-notification notification-view dropdown-menu" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
                                        <li>
                                            <h6>Notifications</h6>
                                            <label class="label label-danger">New</label>
                                        </li>
                                        
                                     
                                    </ul>
                                </div>
                            </li>

                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">

                                        <span><? echo ucwords($_SESSION['username']);?></span>
                                        
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
                                        <input type="text" class="form-control  search-text" placeholder="Search Friend"
                                            id="search-friends">
                                        <div class="form-icon">
                                            <i class="icofont icofont-search"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="main-friend-list">
                                <div class="media userlist-box" data-id="1" data-status="online"
                                    data-username="Josephin Doe" data-toggle="tooltip" data-placement="left"
                                    title="Josephin Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius img-radius"
                                            src="" alt="Generic placeholder image ">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Josephin Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="2" data-status="online"
                                    data-username="Lary Doe" data-toggle="tooltip" data-placement="left"
                                    title="Lary Doe">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Lary Doe</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="3" data-status="online" data-username="Alice"
                                    data-toggle="tooltip" data-placement="left" title="Alice">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alice</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="4" data-status="online" data-username="Alia"
                                    data-toggle="tooltip" data-placement="left" title="Alia">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
                                        <div class="live-status bg-success"></div>
                                    </a>
                                    <div class="media-body">
                                        <div class="f-13 chat-header">Alia</div>
                                    </div>
                                </div>
                                <div class="media userlist-box" data-id="5" data-status="online" data-username="Suzen"
                                    data-toggle="tooltip" data-placement="left" title="Suzen">
                                    <a class="media-left" href="#!">
                                        <img class="media-object img-radius" src=""
                                            alt="Generic placeholder image">
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
                        <img class="media-object img-radius img-radius m-t-5" src=""
                            alt="Generic placeholder image">
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
                            <img class="media-object img-radius img-radius m-t-5"
                                src="" alt="Generic placeholder image">
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
                        /*@font-face {*/
                        /*    font-family: oswald;*/
                        /*    src: url(fonts/Exo2-VariableFont_wght.ttf);*/
                        /*    font-display: block;*/
                        /*}*/
                        /*body{*/
                        /*        font-family: oswald;*/
                        /*}*/
                    </style>
                    
                    
                    <? include('nav.php');?>
                    
                    
                    
                    
<script>
    window.addEventListener('load', function() {
        var loader = document.querySelector('.loader-block');
        var pcoded = document.querySelector('#pcoded');
        loader.style.display = 'none';
        pcoded.style.visibility = 'visible';
    });
        
    var mobileMenu = document.getElementById('mobile-collapse');
    var iconElement = mobileMenu.querySelector('i');

    mobileMenu.addEventListener('click', function() {
    iconElement.classList.toggle('icon-toggle-right');
    iconElement.classList.toggle('icon-toggle-left');
});
    
                    // var logoutTimeout;
                        
                    //     function startLogoutTimer() {
                    //       logoutTimeout = setTimeout(logout, 3600000); // 1 Hour in milliseconds
                    //     }
                        
                    //     function resetLogoutTimer() {
                    //       clearTimeout(logoutTimeout);
                    //       startLogoutTimer();
                    //     }
                        
                    //     function logout() {
                    //       window.location.href = 'logout.php';
                    //     }
                        
                    //     document.addEventListener('mousemove', resetLogoutTimer);
                    //     document.addEventListener('keydown', resetLogoutTimer);
                    //     document.addEventListener('click', resetLogoutTimer);
                        
                    //     startLogoutTimer();
                    </script>
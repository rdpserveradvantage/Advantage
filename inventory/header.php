<?php include('config.php');
  ini_set('post_max_size', '64M');
  ini_set('upload_max_filesize', '64M');

$token = $_SESSION['advantageInventorytoken'] ;
$advantageInventory = $_SESSION['advantageInventory'];
$site = $_SESSION['site'];

if (!function_exists('verifyToken')) {
    function verifyToken($token){
        global $con; 
    
        $sql = mysqli_query($con,"select * from inventoryUsers where token='".$token."' and user_status=1");
            if($sql_result = mysqli_fetch_assoc($sql)){
                return 1 ; 
        
            }else{
                return 0;
            }    
    }    
}    

// echo $advantageInventory ; 

if(verifyToken($token)!=1 || $site!='advantageInventory'){


    header('Location: login.php');
    exit;
}


?>
<!DOCTYPE html>
<html lang="en" style="text-transform: uppercase;">

<head>
    <title> Advantage </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="#">
    <meta name="author" content="#">
    <!-- Favicon icon -->
    <link rel="icon" href="assets/1601680170_capture.jpg" type="image/x-icon">
    <!-- Google font-->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="files/bower_components/bootstrap/dist/css/bootstrap.min.css">
    
    
   <link rel="stylesheet" type="text/css" href="files/assets/icon/feather/css/feather.css">
    
    
    
<link rel="stylesheet" type="text/css" href="files/assets/icon/themify-icons/themify-icons.css">

<link rel="stylesheet" type="text/css" href="files/assets/icon/icofont/css/icofont.css">


    
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/style.css">
    <link rel="stylesheet" type="text/css" href="files/assets/css/jquery.mCustomScrollbar.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link href="select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
    <script src="select2/dist/js/select2.min.js" defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v3.0.0/css/line.css" type="text/css"></link>
<link rel="stylesheet" href="https://preview.pichforest.com/dashonic/layouts/assets/css/app.min.css" type="text/css"></link>

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
  33.3%, 66% {
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
  33.3%, 66% {
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
  33.3%, 66% {
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
  33.3%, 66% {
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


.loader-block{
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
                        <ul class="nav-left" style="background: #01a9ac;">
                            <li class="header-search strong" style="font-size: 17px;color: white;">
                                Inventory Portal
                            </li>
                        </ul>
                        <ul class="nav-right">
                            <li class="user-profile header-notification">
                                <div class="dropdown-primary dropdown">
                                    <div class="dropdown-toggle" data-toggle="dropdown">
                                        <span class="strong"><? echo ucwords($_SESSION['username']);?></span>
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
                    body{
                        zoom:0.8;
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
                    
                    
                    <? include('nav.php');?>
                    
                    
                    
                    
                    <script>
                    
                    var logoutTimeout;
                        
                        function startLogoutTimer() {
                          logoutTimeout = setTimeout(logout, 3600000); // 1 Hour in milliseconds
                        }
                        
                        function resetLogoutTimer() {
                          clearTimeout(logoutTimeout);
                          startLogoutTimer();
                        }
                        
                        function logout() {
                          window.location.href = 'logout.php';
                        }
                        
                        document.addEventListener('mousemove', resetLogoutTimer);
                        document.addEventListener('keydown', resetLogoutTimer);
                        document.addEventListener('click', resetLogoutTimer);
                        
                        startLogoutTimer();
                    </script>
                    
                    
                    
                         
         <script>
        function unlockIPs() {
            // Use jQuery's $.ajax function for the AJAX request
            $.ajax({
                type: 'GET',
                url: 'unLockIPs.php',
                success: function (response) {
                    // You can handle the response here if needed
                    console.log(response);
                },
                error: function (xhr, status, error) {
                    // Handle any errors here
                    console.error(xhr.responseText);
                }
            });
        }

        // Call unlockIPs function every 10 seconds
        setInterval(unlockIPs, 10000); // 10,000 milliseconds = 10 seconds
    
    

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
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  
  <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/fonts/iconic/css/material-design-iconic-font.min.css">

<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/css/util.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/css/main.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<meta name="robots" content="noindex, follow">






  <style>
    body {
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
    }

    #overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5); /* Overlay color and transparency */
      z-index: 1;
    }

    .wrap-login100 {
      position: absolute;
      top: 50%;
      right: 20%;
      transform: translate(50%, -50%);
      border: 1px solid;
      padding: 35px;
      width: 300px;
      background: white;
      z-index: 2;
    }

    .carousel-inner img {
      width: 100vw;
      height: 100vh;
    }
    .wrap-login100 {
    width: 350px;
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
}

.p-r-55 {
    padding-right: 55px;
}
.p-l-55 {
    padding-left: 55px;
}
.p-b-54 {
    padding-bottom: 54px;
}
.p-t-65 {
    padding-top: 65px;
}
.login100-form {
    width: 100%;
}
.hrDivider {
    margin: 20px auto;
}
.login100-form-title {
    font-size: 25px;
}

.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{
    width: 100%;
}

body{
    zoom:0.8;
}
  </style>
</head>
<body>

<div id="overlay"></div>

<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox">
      <div class="item active">
        <img src="./assets/pic1.jpg" alt="Los Angeles">
      </div>

      <div class="item">
        <img src="./assets/pic2.jpg" alt="Chicago">
      </div>

      <div class="item">
        <img src="./assets/noRecords.png" alt="Chicago">
      </div>
    </div>
</div>

<div class="wrap-login100">
<form id="loginForm" class="login100-form validate-form" method="POST">
  <span class="login100-form-title">
  Clarity - Login 
    </span>
      
  <!-- <div class="logo" style="text-align: center;">
      <img src="assets/service.gif" class="logo_img">
    </div> -->
    <hr class="hrDivider">
    <div class="wrap-input100 validate-input m-b-23" data-validate="Username is required">
      <span class="label-input100">Username</span>
      <input class="input100" type="text" name="username" placeholder="Type your username">
      <span class="focus-input100" data-symbol=""></span>
    </div>
    <div class="wrap-input100 validate-input" data-validate="Password is required">
      <span class="label-input100">Password</span>
      <input class="input100" type="password" name="password" placeholder="Type your password">
      <span class="focus-input100" data-symbol=""></span>
    </div>
    <div class="text-right p-t-8 p-b-31">
      <a href="#">
        Forgot password?
      </a>
    </div>
    <div class="container-login100-form-btn">
      <div class="wrap-login100-form-btn">
        <div class="login100-form-bgbtn"></div>
        <button class="login100-form-btn">
          Login
        </button>
      </div>
    </div>
  </form>
</div>

<script>
  $(document).ready(function(){
    $('#myCarousel').carousel({
      interval: 3000 // Change slide every 3 seconds
    });
  });
</script>


<script>
        
        
        $(document).ready(function () {
            $("#loginForm").submit(function (e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            type: "POST",
            url: "process_login.php", // Change this to the actual URL of your login process script
            data: $(this).serialize(),
            dataType: "json",
            success: function (response) {
                
                console.log(response);
                
                if (response.success) {
                    Swal.fire({
                        title: "Login Successful",
                        text: "Redirecting...",
                        icon: "success",
                        showConfirmButton: false,
                        timer: 1500,
                        didClose: () => {
                            window.location.href = response.redirect;
                        },
                    });
                } else {
                    Swal.fire({
                        title: "Login Failed",
                        text: response.message,
                        icon: "error",
                        showConfirmButton: true, // You can use true or false based on your preference
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    title: "Error",
                    text: "An error occurred. Please try again later.",
                    icon: "error",
                    showConfirmButton: true, // You can use true or false based on your preference
                });
            }
        });
    });
        });

    </script>

</body>
</html>

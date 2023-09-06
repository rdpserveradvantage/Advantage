<? include('config.php');

$token = $_SESSION['isServicePortalToken'] ;

if (!function_exists('verifyToken')) {
    function verifyToken($token){
        global $con; 
        $sql = mysqli_query($con,"select * from vendorUsers where token='".$token."' and user_status=1");
            if($sql_result = mysqli_fetch_assoc($sql)){
                return 1 ; 
        
            }else{
                return 0;
            }    
    }    
}    



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title> Login | Advantage </title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">


    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/fonts/iconic/css/material-design-iconic-font.min.css">

    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/css/util.css">
    <link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/css/main.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <meta name="robots" content="noindex, follow">
    <script nonce="dfe7ab33-27b7-45bd-8991-0e03e8494a46">(function(w,d){!function(f,g,h,i){f[h]=f[h]||{};f[h].executed=[];f.zaraz={deferred:[],listeners:[]};f.zaraz.q=[];f.zaraz._f=function(j){return function(){var k=Array.prototype.slice.call(arguments);f.zaraz.q.push({m:j,a:k})}};for(const l of["track","set","debug"])f.zaraz[l]=f.zaraz._f(l);f.zaraz.init=()=>{var m=g.getElementsByTagName(i)[0],n=g.createElement(i),o=g.getElementsByTagName("title")[0];o&&(f[h].t=g.getElementsByTagName("title")[0].text);f[h].x=Math.random();f[h].w=f.screen.width;f[h].h=f.screen.height;f[h].j=f.innerHeight;f[h].e=f.innerWidth;f[h].l=f.location.href;f[h].r=g.referrer;f[h].k=f.screen.colorDepth;f[h].n=g.characterSet;f[h].o=(new Date).getTimezoneOffset();if(f.dataLayer)for(const s of Object.entries(Object.entries(dataLayer).reduce(((t,u)=>({...t[1],...u[1]})),{})))zaraz.set(s[0],s[1],{scope:"page"});f[h].q=[];for(;f.zaraz.q.length;){const v=f.zaraz.q.shift();f[h].q.push(v)}n.defer=!0;for(const w of[localStorage,sessionStorage])Object.keys(w||{}).filter((y=>y.startsWith("_zaraz_"))).forEach((x=>{try{f[h]["z_"+x.slice(7)]=JSON.parse(w.getItem(x))}catch{f[h]["z_"+x.slice(7)]=w.getItem(x)}}));n.referrerPolicy="origin";n.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(f[h])));m.parentNode.insertBefore(n,m)};["complete","interactive"].includes(g.readyState)?zaraz.init():f.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
    <body>


    <?  if(verifyToken($token)==1){ ?>

<script>

                    Swal.fire({
                        title: "You Have Active Session.. !",
                        text: "Redirecting...",
                        icon: "info",
                        showConfirmButton: false,
                        timer: 1500,
                        didClose: () => {
                            window.location.href = 'index.php';
                        },
                    });

</script>        
<? }  ?>



        <style>
            .container-login100 {
                width: 100%;
                min-height: 100vh;
                display: -webkit-box;
                display: -webkit-flex;
                display: -moz-box;
                display: -ms-flexbox;
                display: flex;
                flex-wrap: wrap;
                justify-content: space-around;
                align-items: center;
                padding: 15px;
                background-repeat: no-repeat;
                background-position: center;
                background-size: cover;
            }

            .logo_img{
                width: auto;
                height: 65px;
            }
            
            .login100-form-title{
                font-size:25px;
            }
            .hrDivider{
                margin: 20px auto;
            }
            .content-right {
               width: 50%;
               text-align:center;
           }
           .content-right img {
            
            width: 60%;
            // -webkit-animation: bounce 3s ease-in-out infinite;
            // animation: bounce 3s ease-in-out infinite;
            -webkit-transition: -webkit-transform 300ms cubic-bezier(0,0,0.3,1);
            transition: -webkit-transform 300ms cubic-bezier(0,0,0.3,1);
            -o-transition: transform 300ms cubic-bezier(0,0,0.3,1);
            transition: transform 300ms cubic-bezier(0,0,0.3,1);
            will-change: transform;
        }

        @keyframes bounce {
            0%, 100% {
                -webkit-transform: translateY(0);
                transform: translateY(0);
            }

            50% {
                -webkit-transform: translateY(-20px);
                transform: translateY(-20px);
            }
        }

    </style>




    <div class="limiter" style="height: 100vh;">
        <div class="container-login100" style="zoom:0.8;height: inherit;
        
        " >
            <div class="content-right wrap-login100" style="background:transparent ; ">
                <img src="assets/10945826.png" alt="color gradient spacecraft" title="color gradient spacecraft">
            </div>

            <div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54" style="    border: 1px solid;">

                <form id="loginForm" class="login100-form validate-form" method="POST">

                    <div class="logo" style="text-align: center;">
                        <img src="assets/service.gif"  class="logo_img"/>
                    </div>
                    <hr class="hrDivider">
                    <span class="login100-form-title p-b-49">
                        Login - Clarity
                    </span>
                    <div class="wrap-input100 validate-input m-b-23" data-validate="Username is reauired">
                        <span class="label-input100">Username</span>
                        <input class="input100" type="text" name="username" placeholder="Type your username">
                        <span class="focus-input100" data-symbol="&#xf206;"></span>
                    </div>
                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <span class="label-input100">Password</span>
                        <input class="input100" type="password" name="password" placeholder="Type your password">
                        <span class="focus-input100" data-symbol="&#xf190;"></span>
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
        </div>
    </div>


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

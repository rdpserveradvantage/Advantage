<!DOCTYPE html>
<html lang="en">
<head>
<title> Login | Advantage </title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">


<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/fonts/iconic/css/material-design-iconic-font.min.css">

<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/css/util.css">
<link rel="stylesheet" type="text/css" href="https://colorlib.com/etc/lf/Login_v4/css/main.css">

<meta name="robots" content="noindex, follow">
<script nonce="dfe7ab33-27b7-45bd-8991-0e03e8494a46">(function(w,d){!function(f,g,h,i){f[h]=f[h]||{};f[h].executed=[];f.zaraz={deferred:[],listeners:[]};f.zaraz.q=[];f.zaraz._f=function(j){return function(){var k=Array.prototype.slice.call(arguments);f.zaraz.q.push({m:j,a:k})}};for(const l of["track","set","debug"])f.zaraz[l]=f.zaraz._f(l);f.zaraz.init=()=>{var m=g.getElementsByTagName(i)[0],n=g.createElement(i),o=g.getElementsByTagName("title")[0];o&&(f[h].t=g.getElementsByTagName("title")[0].text);f[h].x=Math.random();f[h].w=f.screen.width;f[h].h=f.screen.height;f[h].j=f.innerHeight;f[h].e=f.innerWidth;f[h].l=f.location.href;f[h].r=g.referrer;f[h].k=f.screen.colorDepth;f[h].n=g.characterSet;f[h].o=(new Date).getTimezoneOffset();if(f.dataLayer)for(const s of Object.entries(Object.entries(dataLayer).reduce(((t,u)=>({...t[1],...u[1]})),{})))zaraz.set(s[0],s[1],{scope:"page"});f[h].q=[];for(;f.zaraz.q.length;){const v=f.zaraz.q.shift();f[h].q.push(v)}n.defer=!0;for(const w of[localStorage,sessionStorage])Object.keys(w||{}).filter((y=>y.startsWith("_zaraz_"))).forEach((x=>{try{f[h]["z_"+x.slice(7)]=JSON.parse(w.getItem(x))}catch{f[h]["z_"+x.slice(7)]=w.getItem(x)}}));n.referrerPolicy="origin";n.src="/cdn-cgi/zaraz/s.js?z="+btoa(encodeURIComponent(JSON.stringify(f[h])));m.parentNode.insertBefore(n,m)};["complete","interactive"].includes(g.readyState)?zaraz.init():f.addEventListener("DOMContentLoaded",zaraz.init)}(w,d,"zarazData","script");})(window,document);</script></head>
<body>


<style>
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
    .container-login100{
        zoom:0.8;
        height: 100%;
    }
    .limiter{
        height: 100%;
    }
    .content-right {
    width: 50%;
    text-align: center;
}
.content-right img{
    width:220px;
}

.instagram-style-text {
  font-family: "YourSelectedFont", cursive;
  font-size: 48px;
  letter-spacing: 8px;
  font-style: italic;
  background: linear-gradient(45deg, #fd5, #ff543e, #c837ab, #5851db, #405de6, #0072ff, #00a8ff, #00c6ff, #a8f9ff);
  -webkit-background-clip: text;
  background-clip: text;
  color: transparent;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
}

.content-right img {
    

    -webkit-animation: bounce 3s ease-in-out infinite;
    animation: bounce 3s ease-in-out infinite;
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
<div class="limiter">
<div class="container-login100" style="background-image: url('https://colorlib.com/etc/lf/Login_v4/images/bg-01.jpg');">
    <div class="content-right wrap-login100" style="background:transparent ; ">
    	<img src="assets/track.png" alt="color gradient spacecraft" title="color gradient spacecraft">
    	  <div class="instagram-style-text">Inventory</div>
    </div>
<div class="wrap-login100 p-l-55 p-r-55 p-t-65 p-b-54">

<form action="process_login.php" class="login100-form validate-form" method="POST">
<div class="logo" style="text-align: center;">
    <img src="assets/1601680170_capture.jpg"  class="logo_img"/>
</div>
<hr class="hrDivider">
<span class="login100-form-title p-b-49">
Login
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

</body>
</html>

<html lang="en"><head>
  <meta charset="UTF-8">
  

    <link rel="apple-touch-icon" type="image/png" href="https://cpwebassets.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png">

    <meta name="apple-mobile-web-app-title" content="CodePen">

    <link rel="shortcut icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico">

    <link rel="mask-icon" type="image/x-icon" href="https://cpwebassets.codepen.io/assets/favicon/logo-pin-b4b4269c16397ad2f0f7a01bcdf513a1994f4c94b8af2f191c09eb0d601762b1.svg" color="#111">



  
  

  <title>CodePen - Seeding</title>

    <link rel="canonical" href="https://codepen.io/alvarotrigo/pen/MWvPbMW">
  
  
  
  
<style>
html, body { 
  height: 100%; 
  margin: 0; 
  overflow: hidden;
  overflow: clip; 
  contain: content;
}
body {
  display: flex;
  align-items: center;
  justify-content: center;
  background: #000; 
}
</style>

  <script>
  window.console = window.console || function(t) {};
</script>

  
  
</head>

<body translate="no">
  <css-doodle>
  <style>
    @grid: 50x1 / 50vmin;
    :container {
      perspective: 23vmin;
    }
    background: @m(
      @r(200, 240), 
      radial-gradient(
        @p(#00b8a9, #f8f3d4, #f6416c, #ffde7d) 15%,
        transparent 50%
      ) @r(100%) @r(100%) / @r(1%, 3%) @lr no-repeat
    );

    @size: 80%;
    @place-cell: center;

    border-radius: 50%;
    transform-style: preserve-3d;
    animation: scale-up 20s linear infinite;
    animation-delay: calc(@i * -.4s);

    @keyframes scale-up {
      0% {
        opacity: 0;
        transform: translate3d(0, 0, 0) rotate(0);
      }
      10% { 
        opacity: 1; 
      }
      95% {
        transform:
          translate3d(0, 0, @r(50vmin, 55vmin))
          rotate(@r(-360deg, 360deg));
      }
      100% {
        opacity: 0;
        transform: translate3d(0, 0, 1vmin);
      }
    }
  </style>
</css-doodle>
  <script src="https://unpkg.com/css-doodle@0.17.2/css-doodle.min.js"></script>
  
  



</body></html>
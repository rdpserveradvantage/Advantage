<? session_start();

if($_SESSION['username']){ 

include('header.php');
?>

        <script src="https://code.highcharts.com/highcharts.js"></script>
     
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <div class="page-body">
                                <div class="card">
                                    <div class="card-block">
                                        
                                  
            HI
            
            
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
              
                  
                  

    
    
      
                    
    <? include('footer.php');
    }
else{ ?>
    
    <script>
        window.location.href="login.php";
    </script>
<? }
    ?>
</body>

</html>
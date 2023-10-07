<? include('header.php'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row" id="part1"></div>
                    <div class="row" id="part2"></div>

                </div>
            </div>
        </div>
    </div>
</div>





<? if ($PROJECT_level == 5) { ?>

    <script>
        window.location.href = "BDashboard.php";
    </script>

<?    }else{ ?>
    
    
    
    <script>
         $(document).ready(function() {
        // Load content for part1 asynchronously
        $.ajax({
            url: 'part11Dashboard.php',
            method: 'GET',
            success: function(response) {
                
                console.log(response);
                $('#part1').html(response);
            },
            error: function() {
                $('#part1').html('Error loading part1 content.');
            }
        });
});
    </script>
<? } ?>



<? include('footer.php'); ?>
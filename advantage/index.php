<?php include('header.php'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    
                        
                            <div class="row" id="part1" page="part1Dashboard"></div>
                            <div class="row" id="part2" page="part2Dashboard"></div>
                            <div class="row" id="part3" page="part3Dashboard"></div>
                    

                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                            <span>Clarify - Service</span>
                        </h6>
                        <br>
                            <div class="row" id="part5" page="part5Dashboard"></div>
                        
                        
                        <h6 class="card-subtitle line-on-side text-muted text-xs-center font-small-3 pt-2">
                            <span>Inventory</span>
                        </h6>
                        <br>
                            <div class="row" id="part4" page="part4Dashboard"></div>
                    
                    
                    
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Load content for part1 asynchronously
        $.ajax({
            url: 'part1Dashboard.php',
            method: 'GET',
            success: function(response) {
                $('#part1').html(response);
            },
            error: function() {
                $('#part1').html('Error loading part1 content.');
            }
        });

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
        
        $.ajax({
            url: 'part4Dashboard.php',
            method: 'GET',
            success: function(response) {
                $('#part4').html(response);
            },
            error: function() {
                $('#part4').html('Error loading part4 content.');
            }
        });
        
        $.ajax({
            url: 'part5Dashboard.php',
            method: 'GET',
            success: function(response) {
                $('#part5').html(response);
            },
            error: function() {
                $('#part5').html('Error loading part4 content.');
            }
        });
        
    });
</script>
<?php include('footer.php'); ?>

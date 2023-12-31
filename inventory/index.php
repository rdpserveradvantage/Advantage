<?php include('header.php'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row" id="part1" page="part1Dashboard"></div>
                    <div class="row" id="part2" page="part2Dashboard"></div>
                    <div class="row" id="part3" page="part3Dashboard"></div>
                    <!--<div class="row" id="part4" page="part4Dashboard"></div>-->
                </div>
            </div>
        </div>
    </div>
</div>

<style>
     #donutchart {
        width: 100%; /* Make the chart container expand to the full width of its parent */

        height: auto; /* Allow the chart's height to adjust automatically */
    }
</style>
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

        // // Load content for part3 asynchronously
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
        
        // $.ajax({
        //     url: 'part4Dashboard.php',
        //     method: 'GET',
        //     success: function(response) {
        //         $('#part4').html(response);
        //     },
        //     error: function() {
        //         $('#part4').html('Error loading part4 content.');
        //     }
        // });
        
    });
</script>
<?php include('footer.php'); ?>

<?php include('header.php'); ?>
<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row" id="part1"></div>
                    <div class="row" id="part2"></div>
                    <div class="row" id="part3"></div>
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

        // // Load content for part3 asynchronously
        // $.ajax({
        //     url: 'part3Dashboard.php',
        //     method: 'GET',
        //     success: function(response) {
        //         $('#part3').html(response);
        //     },
        //     error: function() {
        //         $('#part3').html('Error loading part3 content.');
        //     }
        // });
    });
</script>
<?php include('footer.php'); ?>

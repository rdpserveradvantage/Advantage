<? include('header.php'); ?>

<script src="https://code.highcharts.com/highcharts.js"></script>

<div class="pcoded-content">
    <div class="pcoded-inner-content">
        <div class="main-body">
            <div class="page-wrapper">
                <div class="page-body">
                    <div class="row" id="part2"></div>
                    <div class="row" id="part3"></div>

                </div>
            </div>
        </div>
    </div>
</div>





<? if ($PROJECT_level == 5) { ?>

    <script>
        window.location.href = "BDashboard.php";
    </script>

<?    }     ?>



<? include('footer.php'); ?>
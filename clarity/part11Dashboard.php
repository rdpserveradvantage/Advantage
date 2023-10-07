<?php include('config.php');


$query1 = "select COUNT(1) as count from delegation where engineerId='".$userid."' and status=1 and isFeasibilityDone = 1";
$query2 = "select COUNT(1) as count from delegation where engineerId='".$userid."' and status=1 and isFeasibilityDone = 0";
// $query3 = "select count(1) as count from vendormaterialsend a JOIN vendormaterialsenddetails b ON a.id=b.materialSendId where a.contactPersonName='".$userid."'";
$query3 = "select count(1) as count from assignedInstallation where assignedToId='".$userid."' and status=1 and isDone=1";
$query4 = "select count(1) as count from assignedInstallation where assignedToId='".$userid."' and status=1 and isDone=0";


// $queries = [$query1, $query2, $query3, $query4, $query5];
$queries = [$query1, $query2, $query3,  $query4];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Feasibility Done",
    "Feasibility Pending",
    "Installation Done",
    "Installation Pending"
];

$links = [
    "sitestest.php",
    "sitestest.php?isDelegated=1",
    "sitestest.php?isFeasibiltyDone=1",
    // "materialRequest.php",
    "completedInstallation.php"
];

$icon = [
    "uil-list-ul",
    "uil-check-circle",
    "uil-users-alt",
    "uil-clock-eight",
    // "bg-c-yellow"
];






 for ($i = 0; $i < count($titles); $i++) { ?>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0 me-3">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title text-primary rounded-circle font-size-18">
                                                        <i class="uil <?= $icon[$i]; ?> "></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-truncate text-muted">
                                                    <a href="<?= $links[$i]; ?>"><?= $titles[$i]; ?></a>
                                                </p>
                                                <h5 class="font-size-16 mb-0"><?= $results[$i]; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
<? } 






$materialSql = "select b.attribute,count(1) as total from vendormaterialsend a join vendormaterialsenddetails b on a.id=b.materialSendId and a.contactPersonName='".$userid."'
group by b.attribute";
$query = $materialSql ; 

$result = mysqli_query($con, $query);
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
$total = $row['total'];
$attribute = $row['attribute'];
    $data[] = array(
        $attribute => $total,
    );
}


?>

<!-- Include Highcharts library -->
<script src="https://code.highcharts.com/highcharts.js"></script>

<div class="col-sm-12">
    <div class="card">
        <div class="card-block">
            <div id="chartdiv" style="height: 300px; overflow: hidden; text-align: left;"></div>
            <a style="cursor: pointer;" id="fullScreenButton">View Full Screen</a>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- Your PHP code to generate data -->
<?php
// Your PHP code to generate data
$materialSql = "select b.attribute, count(1) as total from vendormaterialsend a join vendormaterialsenddetails b on a.id=b.materialSendId and a.contactPersonName='".$userid."'
group by b.attribute";
$query = $materialSql; 

$result = mysqli_query($con, $query);
$data = array();

while ($row = mysqli_fetch_assoc($result)) {
    $total = (int)$row['total']; // Convert the count to an integer
    $attribute = $row['attribute'];
    $data[] = array(
        "materialName" => $attribute,
        "count" => $total,
    );
}
?>

<!-- Chart code -->
<script>
    var data = <?php echo json_encode($data); ?>;
    
   
   Highcharts.chart('chartdiv', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Material Count Report'
    },
    xAxis: {
        categories: data.map(item => item.materialName),
        title: {
            text: 'Material Name'
        }
    },
    yAxis: {
        title: {
            text: 'Count'
        }
    },
    tooltip: {
        formatter: function () {
            return '<b>' + this.point.category + '</b>: ' + this.point.y + ' counts';
        }
    },
    legend: {
        enabled: false
    },
    series: [{
        name: 'Count',
        data: data.map(item => item.count),
        dataLabels: {
            enabled: true,
            format: '{point.y}', // Display count on top of each bar
            style: {
                fontWeight: 'bold'
            }
        },
        colorByPoint: true, // Use different colors for each bar
    }],
    plotOptions: {
        column: {
            pointWidth: 40, // Set the desired width (in pixels) for the columns
        }
    },
    credits: {
        enabled: false
    }
});


    // Function to enter full screen mode
    function enterFullScreen() {
        var chartContainer = document.getElementById('chartdiv');
        if (chartContainer.requestFullscreen) {
            chartContainer.requestFullscreen();
        } else if (chartContainer.mozRequestFullScreen) {
            chartContainer.mozRequestFullScreen();
        } else if (chartContainer.webkitRequestFullscreen) {
            chartContainer.webkitRequestFullscreen();
        } else if (chartContainer.msRequestFullscreen) {
            chartContainer.msRequestFullscreen();
        }
    }

    // Function to exit full screen mode
    function exitFullScreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
    }

    // Add event listener to the Full Screen button
    var fullScreenButton = document.getElementById('fullScreenButton');
    fullScreenButton.addEventListener('click', function () {
        if (document.fullscreenElement) {
            exitFullScreen();
            fullScreenButton.textContent = 'View Full Screen';
        } else {
            enterFullScreen();
            fullScreenButton.textContent = 'Exit Full Screen';
        }
    });

    // Event listener to exit full screen mode when 'Esc' key is pressed
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            exitFullScreen();
            fullScreenButton.textContent = 'View Full Screen';
        }
    });
</script>

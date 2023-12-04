<?php include('config.php');

                                
    $query1 = "SELECT COUNT(1) AS count FROM sites WHERE status = 1 and delegatedToVendorId='".$RailTailVendorID."'";
    $query2 = "SELECT COUNT(1) AS count FROM sites WHERE isDelegated = 1  and delegatedToVendorId='".$RailTailVendorID."'";
    $query3 = "SELECT COUNT(1) AS count FROM sites WHERE isfeasibiltyDone = 1  and delegatedToVendorId='".$RailTailVendorID."'";
    $query5 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and status=1 and vendor='".$RailTailVendorID."'";    


// $queries = [$query1, $query2, $query3, $query4, $query5];
$queries = [$query1, $query2, $query3,  $query5];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Active Sites",
    "Total Sites Delegated",
    "Total Feasibility Done",
    // "Material Request Pending",
    "Total Installation Done"
];

$links = [
    "#",
    "#",
    "#",
    "#"
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
                                                <div class="avatar">
                                                    <div class="avatar-title rounded-circle font-size-18" style="background-color: #01a9ac !important;">
                                                        <i class="uil <?= $icon[$i]; ?> "></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1 text-truncate text-muted">
                                                    <a href="<?= $links[$i]; ?>" style="font-size: 15px;color: #01a9ac !important;">
                                                        <?= $titles[$i]; ?>
                                                    </a>
                                                </p>
                                                        <h5 class="font-size-16 mb-0"><span class="count"><?= $results[$i] ; ?></span></h5>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<? } 



$query = "SELECT v.id,v.vendorName, COUNT(s.delegatedToVendorId) AS siteAllocated, 
          COALESCE(SUM(s.delegatedByVendor = 1), 0) AS assignEngineer,
          COALESCE(SUM(s.isFeasibiltyDone = 1), 0) AS feasibiltyDone
          FROM vendor v
          LEFT JOIN sites s ON v.id = s.delegatedToVendorId
          where v.id = '".$RailTailVendorID."'
          GROUP BY v.id";
$result = mysqli_query($con, $query);

$data = array();

while ($row = mysqli_fetch_assoc($result)) {

$vendorId = $row['id'];
$query4 = mysqli_query($con,"SELECT COUNT(DISTINCT siteid) AS count FROM material_requests WHERE status='pending' AND isProject=1 and vendorId='".$vendorId."'");
$query4_result = mysqli_fetch_assoc($query4);
$materialRequest = $query4_result['count'];

$query5 = mysqli_query($con,"SELECT COUNT(1) AS count FROM material_send where vendorId='".$vendorId."'");
$query5_result = mysqli_fetch_assoc($query5);
$materialSend = $query5_result['count']; 


$query5 = "SELECT COUNT(distinct atmid) AS count FROM projectInstallation where isDone=1 and vendor='".$vendorId."' and status=1";
$totalInstallationSql = mysqli_query($con,$query5);
$totalInstallationSqlResult = mysqli_fetch_assoc($totalInstallationSql);
$totalInstallationDone = $totalInstallationSqlResult['count'];

    $vendorName = $row['vendorName'];
    $siteAllocated = $row['siteAllocated'];
    $assignEngineer = $row['assignEngineer'];
    $feasibiltyDone = $row['feasibiltyDone'];

    $data[] = array(
        "Vendor" => $vendorName,
        "siteAllocated" => $siteAllocated,
        "assignEngineer" => $assignEngineer,
        "feasibiltyDone" => $feasibiltyDone,
        "materialRequest" => $materialRequest,
        "materialSend" => $materialSend,
        "project" => $totalInstallationDone
    );
}


?>
<!-- Include Highcharts library -->
<script src="https://code.highcharts.com/highcharts.js"></script>

<div class="col-sm-12">
    <div class="card">
        <div class="card-block">
            <div id="chartdiv" style="height: 300px; overflow: hidden; text-align: left;"></div>
              <a id="fullScreenButton" style="cursor:pointer;">View Full Screen</a>

        </div>
    </div>
</div>

<script src="https://code.highcharts.com/modules/exporting.js"></script>

<!-- Chart code -->
<script>
    var data = <?php echo json_encode($data); ?>;
    data.forEach(function(item) {
        item.siteAllocated = parseInt(item.siteAllocated);
        item.assignEngineer = parseInt(item.assignEngineer);
        item.feasibiltyDone = parseInt(item.feasibiltyDone);
        item.materialRequest = parseInt(item.materialRequest);
        item.materialSend = parseInt(item.materialSend);
        item.project = parseInt(item.project);
    });

    Highcharts.chart('chartdiv', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Summarize Report'
        },
        xAxis: {
            categories: data.map(item => item.Vendor),
            title: {
                text: 'Vendor'
            }
        },
        yAxis: {
            title: {
                text: 'Counts'
            }
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.series.name + '</b><br/>' +
                    this.point.category + ': ' + this.point.y;
            }
        },
        legend: {
            align: 'center',
            verticalAlign: 'top',
            layout: 'horizontal',
            itemStyle: {
                fontWeight: 'normal'
            }
        },
        series: [{
            name: 'Site Allocated',
            data: data.map(item => item.siteAllocated)
        }, {
            name: 'Engineer Assign',
            data: data.map(item => item.assignEngineer)
        }, {
            name: 'Feasibility Done',
            data: data.map(item => item.feasibiltyDone)
        }, {
            name: 'Material Request',
            data: data.map(item => item.materialRequest)
        }, {
            name: 'Material Send',
            data: data.map(item => item.materialSend)
        }, {
            name: 'Project Installation',
            data: data.map(item => item.project)
        }],
        plotOptions: {
            column: {
                pointWidth: 40 // Set the desired width (in pixels) for the columns
            },
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.y}'
                }
            }
        },
        credits: {
            enabled: false
        }
    });
    
 function enterFullScreen() {
        var chartContainer = document.getElementById('chartdiv');
        chartContainer.requestFullscreen = chartContainer.requestFullscreen || chartContainer.mozRequestFullScreen || chartContainer.webkitRequestFullscreen || chartContainer.msRequestFullscreen;
        chartContainer.requestFullscreen();
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
            fullScreenButton.textContent = 'Full Screen';
        } else {
            enterFullScreen();
            fullScreenButton.textContent = 'Full Screen';
        }
    });

    // Event listener to exit full screen mode when 'Esc' key is pressed
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            exitFullScreen();
            fullScreenButton.textContent = 'Full Screen';
        }
    });
</script>

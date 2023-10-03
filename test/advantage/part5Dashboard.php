<? include('config.php');
$query1 = "select count(1) as count from mis where status='open'";
$query2 = "select count(1) as count from mis where status='close'";
$query3 = "SELECT COUNT(1) AS count FROM projectInstallation where isDone=1";
$query4 = "SELECT COUNT(1) AS count FROM mis where call_receive_from='Customer / Bank'";
$queries = [$query1, $query2, $query3, $query4];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Open Calls", "Total Close Calls", 'Total Sites', 'Total Calls from Bank'
];

$links = [
    "#", "#", "#", '#'
];

$icon = [
    "fas fa-list-ul",
    "fas fa-check",
    "fas fa-hand-holding-usd",
    "fas fa-piggy-bank",
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
                                                <p class="mb-1 text-truncate text-muted" style="color: #01a9ac !important;">
                                                    <a href="<?= $links[$i]; ?>" style="font-size: 15px;color: #01a9ac !important;"><?= $titles[$i]; ?></a>
                                                </p>
                                                
                                                <h5 class="font-size-16 mb-0"><span class="clarifyCount"><?= $results[$i]; ?></span></h5>
                                                <? $clarifyCount[] = $results[$i] ; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<? } ?>
<div id="sitesAndBankCallsChart" class="col-sm-9" style="width: 400px; height: 300px; float: left;"></div>
<div id="openCloseCallsChart" class="col-sm-3" style="width: 400px; height: 300px; float: left;"></div>



    <script>
        // Prepare data
        var totalOpenCalls = 19;
        var totalCloseCalls = 5;
        var totalSites = 96;
        var totalCallsFromBank = 4;
        // Create a pie chart for open and closed calls
        Highcharts.chart('openCloseCallsChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: ''
            },
            credits: {  // Remove watermark
        enabled: false
    },

            series: [{
                name: 'Calls',
                data: [
                    ['Open Calls', totalOpenCalls],
                    ['Closed Calls', totalCloseCalls]
                ]
            }]
        });

        // Create a bar chart for total sites and total calls from the bank
      // Create a bar chart for total sites and total calls from the bank
Highcharts.chart('sitesAndBankCallsChart', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    credits: {  // Remove watermark
        enabled: false
    },
    xAxis: {
        categories: ['Total Sites', 'Total Calls from Bank']
    },
    yAxis: {
        title: {
            text: 'Count'
        }
    },
    series: [{
        name: 'Bars',
        data: [{
            name: 'Total Sites',
            y: totalSites,
            color: 'green'  // Color for the first bar
        }, {
            name: 'Total Calls from Bank',
            y: totalCallsFromBank,
            color: 'blue'   // Color for the second bar
        }]
    }]
});

    </script>
     <style>
        .report {
            display: flex;
            justify-content: center;
            align-items: flex-end;
            height: 300px;
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            overflow: hidden;
        }

        .wave {
            position: relative;
            width: 100%;
            height: 50px;
            background-color: transparent;
        }

        .upper-wave {
            background: linear-gradient(180deg, rgba(0, 128, 0, 0.8) 0%, rgba(0, 128, 0, 0.2) 100%);
        }

        .lower-wave {
            background: linear-gradient(0deg, rgba(0, 0, 128, 0.8) 0%, rgba(0, 0, 128, 0.2) 100%);
        }

        .count {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }
         #highcharts-container_splinecalls {
        cursor: default; /* or cursor: pointer; */
    }
    </style>
  <?  
    
$queryByHour = "SELECT HOUR(created_at) AS hour, COUNT(*) AS count FROM mis GROUP BY hour";

$resultByHour = mysqli_query($con, $queryByHour);

// Initialize an array to store hour-wise call counts
$callCountsByHour = array_fill(0, 24, 0);

while ($row = mysqli_fetch_assoc($resultByHour)) {
    $hour = $row['hour'];
    $count = $row['count'];
    $callCountsByHour[$hour] = $count;
}

$maxCallCount = max($callCountsByHour);
$maxCallHour = array_search($maxCallCount, $callCountsByHour);
?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>




























 <div id="highcharts-container_splinecalls" style="width:100%; height:300px;"></div>

    <!-- JavaScript for Chart Configuration -->
    <script>
        // Data for the chart (replace with your data)
        // const chartData = [10,90,30,60,50,90,25,55,30,40];
        const chartDataCalls = [3,11,2,2,1,2,4,2,2,2];
        const chartDataCalls2 = [30,4,20,12,13,22,41,22,23,32];

        // Create and configure the Highcharts chart
        Highcharts.chart('highcharts-container_splinecalls', {
            chart: {
                type: 'spline',
                backgroundColor: 'transparent', // Set the background color to transparent
            },
            title: {
                text: null, // Set the chart title to null to hide it
            },
            xAxis: {
                visible: false, // Hide the x-axis
            },
            yAxis: {
                visible: false, // Hide the y-axis
            },
                credits: {  // Remove watermark
        enabled: false
    },
            legend: {
                enabled: false, // Hide the legend
            },
            plotOptions: {
                area: {
                    fillOpacity: 1, // Set the area fill opacity to 1
                },
            },
            series: [{
                data: chartDataCalls,
                color: 'rgba(3, 142, 220, 0.45)', // Set the area color
                lineWidth: 2, // Set the line width
                marker: {
                    radius:2, // Set marker radius to 0 to hide markers
                },
            },
            {
                data: chartDataCalls2,
                color: 'rgba(3, 142, 220, 0.45)', // Set the area color
                lineWidth: 2, // Set the line width
                marker: {
                    radius:0, // Set marker radius to 0 to hide markers
                },
            }],
        });
    </script>
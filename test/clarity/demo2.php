<?php
include('config.php');

// Initialize variables for time range comparison
$timeRange = 'daily'; // Default to daily
$currentTime = date('Y-m-d H:i:s');
$startTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
$endTime = date('Y-m-d H:i:s', strtotime('-48 hours'));

if (isset($_POST['time_range'])) {
    // Handle the selected time range from the dropdown
    $timeRange = $_POST['time_range'];
    switch ($timeRange) {
        case 'weekly':
            $startTime = date('Y-m-d H:i:s', strtotime('-14 days'));
            $endTime = date('Y-m-d H:i:s', strtotime('-7 days'));
            break;
        case 'monthly':
            $startTime = date('Y-m-d H:i:s', strtotime('-60 days'));
            $endTime = date('Y-m-d H:i:s', strtotime('-30 days'));
            break;
        default:
            // Default to daily
            echo 'defaukt' ; 
            $startTime = date('Y-m-d H:i:s', strtotime('-24 hours'));
            $endTime = date('Y-m-d H:i:s', strtotime('0 hours'));
            break;
    }
}


echo $queryByHour = "SELECT HOUR(created_at) AS hour, COUNT(*) AS count FROM mis WHERE created_at BETWEEN '$startTime' AND '$endTime' GROUP BY hour";
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

<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
</head>
<body>
    <div class="col-sm-12">
        <br>
        <div class="card">
            <div class="card-block">
                <style>
                    /* Adjust the container's width and height */
                    .chart-container {
                        width: 600px;
                        height: 300px;
                    }
                </style>

                <!-- Dropdown for selecting time range -->
                <form method="post">
                    <label for="time_range">Select Time Range:</label>
                    <select name="time_range" id="time_range">
                        <option value="daily" <?php echo ($timeRange == 'daily') ? 'selected' : ''; ?>>Daily</option>
                        <option value="weekly" <?php echo ($timeRange == 'weekly') ? 'selected' : ''; ?>>Weekly</option>
                        <option value="monthly" <?php echo ($timeRange == 'monthly') ? 'selected' : ''; ?>>Monthly</option>
                    </select>
                    <input type="submit" value="Submit">
                </form>

                <!-- Chart canvas inside a container with adjusted dimensions -->
                <div class="chart-container">
                    <canvas id="lineChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Get the canvas element and context
        var canvas = document.getElementById('lineChart');
        var ctx = canvas.getContext('2d');
        var maxCallCount = <?php echo $maxCallCount; ?>;
        var maxCallHour = <?php echo $maxCallHour; ?>;

        // Data for the chart
        var data = {
            labels: ['00:00', '01:00', '02:00', '03:00', '04:00', '05:00', '06:00', '07:00', '08:00', '09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00', '19:00', '20:00', '21:00', '22:00', '23:00'],
            datasets: [
                {
                    label: 'Call Count',
                    data: <?php echo json_encode($callCountsByHour); ?>,
                    backgroundColor: 'rgba(0, 128, 0, 0.8)', // Color for the data points
                    borderColor: 'rgba(0, 128, 0, 1)',     // Border color for the data points
                    borderWidth: 1,
                },
            ],
        };

        // Chart configuration
        var config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Count'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Hour'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    annotation: {
                        annotations: [{
                            type: 'line',
                            mode: 'vertical',
                            scaleID: 'x',
                            value: maxCallHour,
                            borderColor: 'red',
                            borderWidth: 1,
                            label: {
                                content: 'Max Calls at ' + maxCallHour + ':00',
                                enabled: true,
                                position: 'top'
                            }
                        }]
                    }
                }
            },
        };

        // Create the line chart
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, config);

    </script>
</body>
</html>

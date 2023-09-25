<?php
include('config.php');

$query = "select * from boq where status=1";
$result = mysqli_query($con, $query);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $materialName[] = trim($row['value']);
}

$qty = array(); // Initialize the $qty array

foreach ($materialName as $materialNameKey => $materialNameValue) {
    $quantitySql = mysqli_query($con, "select count(1) as count from inventory where status=0 and material='" . $materialNameValue . "'");
    $quantitySqlResult = mysqli_fetch_assoc($quantitySql);
    $qty[] = $quantitySqlResult['count'];
}

// var_dump($materialName,$qty);
?>

<div class="col-sm-12">
    <div class="card">
        <div class="card-block">
            <div id="chartdiv" style="height: 400px; overflow: hidden; text-align: left;"></div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>

<!-- Chart code -->
<script>
    // Check if the container exists before initializing the chart
    if (document.getElementById('chartdiv')) {
        // Create an array of data points by combining materialName and qty arrays
        var chartData = [];
        <?php for ($i = 0; $i < count($materialName); $i++) : ?>
            chartData.push({
                materialName: "<?php echo $materialName[$i]; ?>",
                qty: <?php echo $qty[$i]; ?>
            });
        <?php endfor; ?>

        // Define custom colors for each column
        var colors = ['#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9', '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1'];

        // Initialize Highcharts chart with custom options
        Highcharts.chart('chartdiv', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Material Quantities In Stocks'
            },
            xAxis: {
                categories: chartData.map(item => item.materialName),
                title: {
                    text: 'Material Name'
                }
            },
            yAxis: {
                title: {
                    text: 'Quantity'
                }
            },
            series: [{
                name: 'Quantity',
                data: chartData.map((item, index) => ({
                    y: item.qty,
                    color: colors[index] // Assign color from the colors array
                })),
                pointPadding: 0.2,
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y}', // Display the quantity on top of columns
                    style: {
                        fontSize: '12px'
                    }
                }
            }],
            plotOptions: {
                column: {
                    cursor: 'pointer', // Enable cursor pointer for columns
                    events: {
                        click: function (event) {
                            // Handle click event on columns (add your code here)
                            console.log('Clicked on column:', event.point.category);
                        }
                    }
                }
            },
            tooltip: {
                formatter: function () {
                    // Customize the tooltip text
                    return '<b>' + this.x + '</b><br>Quantity: ' + this.y;
                }
            }
        });
    } else {
        // Handle the case where the chart container does not exist
        console.error("Chart container 'chartdiv' not found.");
    }
</script>

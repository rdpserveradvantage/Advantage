<?php
include('config.php');

$query = "select * from boq where status=1";
$result = mysqli_query($con, $query);
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $materialName[] = trim($row['value']);
}



$qty = array(); 

foreach ($materialName as $materialNameKey => $materialNameValue) {

    $quantitySql = mysqli_query($con, "select count(1) as count from vendorinventory where status=0 and material='" . trim($materialNameValue) . "'");
    $quantitySqlResult = mysqli_fetch_assoc($quantitySql);
    $qty[] = $quantitySqlResult['count'];
}

?>

<div class="col-sm-12">
    <div class="card">
        <div class="card-block">
            <div id="chartdiv2" style="height: 400px; overflow: hidden; text-align: left;"></div>
        </div>
    </div>
</div>


<div class="col-sm-6">
    <div class="card">
        <div class="card-block">
            <div id="donutchart2" style="height: 400px; overflow: hidden; text-align: left;"></div>
        </div>
    </div>
</div>

<div class="col-sm-6">
    <div class="card">
        <div class="card-block">
            <table class="table table-hover table-styling table-xs">
                <thead>
                    <tr class="table-primary">
                        <th>Material</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($materialName); $i++) : ?>
                        <tr>
                            <td class="strong"><?php echo $materialName[$i]; ?></td>
                            <td><?php echo $qty[$i]; ?></td>
                        </tr>
                    <?php $totalqty = $totalqty + $qty[$i];
                    endfor; ?>

                    <tr class="table-primary">
                        <th>Total</th>
                        <th><?php echo $totalqty; ?></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>



<script>
    // Check if the container exists before initializing the chart
    if (document.getElementById('chartdiv2')) {
        // Create an array of data points by combining materialName and qty arrays
        var chartData = [];
        <?php for ($i = 0; $i < count($materialName); $i++) : ?>
            chartData.push({
                materialName: "<?php echo $materialName[$i]; ?>",
                qty: <?php echo $qty[$i]; ?>
            });
        <?php endfor; ?>

        // Define custom colors for each column
        var customColors = [
            '#7cb5ec', '#434348', '#90ed7d', '#f7a35c', '#8085e9',
            '#f15c80', '#e4d354', '#2b908f', '#f45b5b', '#91e8e1',
            // Add more custom colors here for additional data points
        ];

        // Initialize Highcharts chart with custom options
        Highcharts.chart('chartdiv2', {
            chart: {
                type: 'column'
            },
            title: {
                text: 'Material Quantities In Stocks - CSS'
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
                    color: customColors[index % customColors.length] // Assign custom colors in a circular manner
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
        console.error("Chart container 'chartdiv2' not found.");
    }
</script>


<script>
    // Check if the container exists before initializing the donut chart
    if (document.getElementById('donutchart2')) {
        // Create an array of data points by combining materialName and qty arrays
        var donutchart2Data = [];
        <?php for ($i = 0; $i < count($materialName); $i++) : ?>
            donutchart2Data.push({
                name: "<?php echo $materialName[$i]; ?>",
                y: <?php echo $qty[$i]; ?>
            });
        <?php endfor; ?>

        // Initialize Highcharts donut chart with custom options
        Highcharts.chart('donutchart2', {
            chart: {
                type: 'pie',
                options3d: {
                    enabled: true,
                    alpha: 45
                }
            },
            title: {
                text: 'Material Quantities In Stocks'
            },
            plotOptions: {
                pie: {
                    innerSize: 100, // Adjust this value to control the size of the hole in the center (donut hole)
                    depth: 45
                }
            },
            credits: {
                enabled: false
            },
            exporting: { // Enable exporting options
                buttons: {
                    contextButton: {
                        menuItems: ['downloadPNG', 'downloadJPEG', 'downloadPDF', 'downloadSVG'] // Add format options
                    }
                }
            },
            series: [{
                name: 'Quantity',
                data: donutchart2Data,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }]
        });
    } else {
        // Handle the case where the donut chart container does not exist
        console.error("Donut chart container 'donutchart2' not found.");
    }
</script>
<?php include('config.php');

                                

    $query1 = "SELECT COUNT(1) AS count FROM inventory WHERE status in(0,1)";
    $query2 = "SELECT COUNT(1) AS count FROM inventory WHERE status = 0";
    $query3 = "SELECT COUNT(1) AS count FROM inventory WHERE status = 1 ";
    $query4 = "SELECT COUNT(1) AS count FROM material_send WHERE isDelivered = 0 ";


// $queries = [$query1, $query2, $query3, $query4, $query5];
$queries = [$query1, $query2, $query3,$query4];
$results = [];

foreach ($queries as $query) {
    $result = mysqli_query($con, $query);
    $count = mysqli_fetch_assoc($result)['count'];
    $results[] = $count;
}

$titles = [
    "Total Inventories",
    "Material Out",
    "On Hand",
    "In-Transit",
    // "Total Installation Done"
];

$links = [
    "#",
    "#?isDelegated=1",
    "#?isFeasibiltyDone=1",
    "#"
];

$icon = [
    "fas fa-warehouse",
    "uil-navigator",
    "fas fa-hand-holding-usd",
    "fas fa-shipping-fast",
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
                                                  <h5 class="font-size-16 mb-0"><span class="inventoryCount"><?= $results[$i] ; ?></span></h5>
                                                <? $inventoryCount[] = $results[$i] ; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            
<? } 





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
?>

<div class="col-sm-12">
    <div class="card">
        <div class="card-block">
            <div id="chartdivInventory" style="height: 400px; overflow: hidden; text-align: left;"></div>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/highcharts.js"></script>

<!-- Chart code -->
<script>
    // Check if the container exists before initializing the chart
    if (document.getElementById('chartdivInventory')) {
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
        Highcharts.chart('chartdivInventory', {
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
            },
            plotOptions: {
        column: {
            pointWidth: 15, // Adjust the width as needed
            cursor: 'pointer',
            events: {
                click: function (event) {
                    console.log('Clicked on column:', event.point.category);
                }
            }
        }
    },

        });
    } else {
        // Handle the case where the chart container does not exist
        console.error("Chart container 'chartdiv' not found.");
    }
</script>





<!-- });

    window.addEventListener('focus', function () {
        countInventoryElements.forEach((element, index) => {
            const startCount = parseFloat(element.textContent);
            const endCount = updatedInventoryCounts[index];
            const animationDuration = 4; // Animation duration in seconds (adjust as needed)

            animateCount(endCount, animationDuration, element);
        });
    });
</script> -->

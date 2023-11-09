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

    $quantitySql = mysqli_query($con, "select count(1) as count from inventory where material='" . trim($materialNameValue) . "'");
    $quantitySqlResult = mysqli_fetch_assoc($quantitySql);
    $qty[] = $quantitySqlResult['count'];
}

?>



<div class="col-sm-6">
    <div class="card">
        <div class="card-block">
            <div id="donutchart" style="height: 400px; overflow: hidden; text-align: left;"></div>
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
    // Check if the container exists before initializing the donut chart
    if (document.getElementById('donutchart')) {
        // Create an array of data points by combining materialName and qty arrays
        var donutChartData = [];
        <?php for ($i = 0; $i < count($materialName); $i++) : ?>
            donutChartData.push({
                name: "<?php echo $materialName[$i]; ?>",
                y: <?php echo $qty[$i]; ?>
            });
        <?php endfor; ?>

        // Initialize Highcharts donut chart with custom options
        Highcharts.chart('donutchart', {
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
                data: donutChartData,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
            }]
        });
    } else {
        // Handle the case where the donut chart container does not exist
        console.error("Donut chart container 'donutchart' not found.");
    }
</script>
<?php
include('config.php'); 

$totalPendingInstallation = array();
$categories = array();
$i = 1; 

$sql = mysqli_query($con, "SELECT vendor, count(1) as totalSites FROM `projectInstallation` WHERE vendor='".$RailTailVendorID."' AND status=1 AND isDone=0 GROUP BY vendor");

while ($sql_result = mysqli_fetch_assoc($sql)) {
    $vendor = $sql_result['vendor'];
    $vendorName = getVendorName($vendor);
    $totalSites = (int)$sql_result['totalSites']; // Convert to integer

    if ($i == 1) {
        $totalPendingInstallation[] = array('name' => $vendorName, 'y' => $totalSites, true, true);
    } else {
        $totalPendingInstallation[] = array('name' => $vendorName, 'y' => $totalSites, false);
    }

    $categories[] = $vendorName;

    $i++;
}

?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="col-sm-4">
    <div class="card">
        <div class="card-block">
            <div id="container" style="height: 400px; margin: 0px auto; overflow: hidden;"></div>
        </div>
    </div>
</div>

<div class="col-sm-8">
    <div class="card">
        <div class="card-block">
            <h6 class="strong">Installation Calls with Most Pending Time</h6>
            <span style="color:red; font-size: 10px;">(Max 6 Records here. Click the below button for more.. )</span>
            <hr />
            <div class="pendingInstallationDashboard overflow_auto">
                <?php
                $i = 1;
                $pendingInstallationSql = mysqli_query($con, "SELECT * FROM projectInstallation WHERE vendor='".$RailTailVendorID."' AND isDone=0 ORDER BY created_at ASC LIMIT 6");
                if (mysqli_num_rows($pendingInstallationSql) > 0) {
                ?>
                <table class="table table-hover table-styling table-xs">
                    <thead>
                        <tr class="table-primary">
                            <th> Vendor </th>
                            <th> Atmid </th>
                            <th> Pending From </th>
                            <th> Duration </th> 
                            <th> SBIN Ticket ID </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($pendingInstallationSqlResult = mysqli_fetch_assoc($pendingInstallationSql)) {
                            $vendorId = $pendingInstallationSqlResult['vendor'];
                            $vendorName = getVendorName($vendorId);
                            $atmid = $pendingInstallationSqlResult['atmid'];
                            $created_at = $pendingInstallationSqlResult['created_at'];
                            $sbiTicketId = $pendingInstallationSqlResult['sbiTicketId'];
                
                            // Calculate the duration using PHP's DateTime class
                            $createdAtDateTime = new DateTime($created_at);
                            $currentDateTime = new DateTime();
                            $durationInterval = $createdAtDateTime->diff($currentDateTime);
                            $duration = $durationInterval->format('%d days, %h hours, %i minutes');
                        ?>
                
                            <tr>
                                <td class="strong"><?= $vendorName; ?></td>
                                <td><?= $atmid; ?></td>
                                <td><?= $created_at; ?></td>
                                <td><?= $duration; ?></td>
                                <td><?= $sbiTicketId; ?></td>
                            </tr>
                
                        <?php
                            $i++;
                        }
                        ?>
                
                    </tbody>
                </table>
                <?php
                } else {
                    echo "<p>No Data Available</p>";
                }
                ?>
                
                
            </div>
            <br />
            <a href="pendingInstallation.php" class="btn btn-primary"> View All Pending Installation </a>
        </div>
    </div>
</div>

<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
    var chartData = <?php echo json_encode($totalPendingInstallation, JSON_NUMERIC_CHECK); ?>;
    Highcharts.chart('container', {
        title: {
            text: 'Pending Installations'
        },
        xAxis: {
            categories: <?php echo json_encode($categories); ?>
        },
        series: [{
            type: 'pie',
            allowPointSelect: true,
            keys: ['name', 'y', 'selected', 'sliced'],
            data: chartData,
            showInLegend: true
        }],
        plotOptions: {
            pie: {
                size: '100px' // Adjust the size here (in percentage or pixels)
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.name}</b>: {point.y}'
        },
         exporting: {
            enabled: true // We'll enable it with our custom button
        }
    });
</script>

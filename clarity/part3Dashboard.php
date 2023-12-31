<?php include('config.php'); 

$totalPendingInstallation = array();
$categories = array();
$i = 1;

$sql = mysqli_query($con, "SELECT p.vendor, v.status, COUNT(1) as totalSites 
                           FROM projectInstallation p
                           LEFT JOIN vendor v ON p.vendor = v.id
                           WHERE p.status = 1 AND p.isDone = 0 and v.status=1 
                           GROUP BY p.vendor");

while ($sql_result = mysqli_fetch_assoc($sql)) {
    $vendor = $sql_result['vendor'];
    $vendorName = getVendorName($vendor);
    $totalSites = (int)$sql_result['totalSites']; // Convert to integer
    $vendorStatus = (int)$sql_result['status']; // Convert to integer (1 for active, 0 for non-active)

    if ($vendorStatus === 1) {
        if ($i == 1) {
            $totalPendingInstallation[] = array('name' => $vendorName, 'y' => $totalSites, 'sliced' => true, 'selected' => true);
        } else {
            $totalPendingInstallation[] = array('name' => $vendorName, 'y' => $totalSites, 'sliced' => false);
        }
        $categories[] = $vendorName;
        $i++;
    }
}

$sqlStatement = "SELECT * FROM projectInstallation WHERE isDone = 0 ORDER BY created_at ASC ";
?>

<script src="https://code.highcharts.com/highcharts.js"></script>
<div class="col-sm-4">
    <div class="card">
        <div class="card-block">
            <div id="container" style="height: 400px;margin: 0px auto;overflow: hidden;"></div>
                <form action="exportPendingSites.php" method="POST">
                    <input type="hidden" name="exportSql" value="<? echo $sqlStatement; ?>">
                    <input type="submit" name="exportsites" class="btn btn-primary" value="Export Data">
                </form>
        </div>
    </div>
</div>

<div class="col-sm-8">
    
    <div class="card">
        <div class="card-block">
            <h6 class="strong">Intallation Calls with Most Pending time </h6>
            <span style="color:red;font-size: 10px;">(Max 7 Records here. Click the below button for more.. )</span>
            <hr />
            <div class="pendingInstallationDashboard overflow_auto">
                
            
                <table class="table table-hover table-styling table-xs">
                    <thead>
                        <tr class="table-primary">
                            <th> Vendor </th>
                            <th> Atmid </th>
                            <th> Pending From </th>
                            <th> Duration </th> <!-- New column -->
                            <th> SBIN Ticket ID </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        
                        $pendingInstallationSql = mysqli_query($con, "select 
                        p.vendor,p.atmid,p.created_at,p.sbiTicketId,v.status
                        from projectInstallation p 
                        LEFT JOIN vendor v ON p.vendor = v.id
                        where isDone=0 and v.status=1 order by created_at asc limit 7");
                        
                        while ($pendingInstallationSqlResult = mysqli_fetch_assoc($pendingInstallationSql)) {
                            
    $vendorStatus = (int)$pendingInstallationSqlResult['status']; // Convert to integer (1 for active, 0 for non-active)
    if ($vendorStatus === 1) {
    
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
                                <td><?= $duration; ?></td> <!-- Display the calculated duration -->
                                <td><?= $sbiTicketId; ?></td>
                            </tr>
                
                        <?php
                            $i++;
    }
                            
                        }
                        ?>
                
                    </tbody>
                </table>  
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
        credits: {
            enabled: false
        },
        tooltip: {
            pointFormat: '<b>{point.name}</b>: {point.y}'
        }
    });

</script>

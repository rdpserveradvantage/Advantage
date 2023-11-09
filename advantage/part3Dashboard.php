<?php include('config.php'); 

$totalPendingInstallation = array();
$categories = array();
$i = 1;
$noRecordsFound = true; // Initialize the flag to true

if($assignedLho){
    $sql = mysqli_query($con, "SELECT p.vendor, v.status, COUNT(1) as totalSites 
                           FROM projectInstallation p
                           INNER JOIN sites s ON p.atmid=s.atmid
                           LEFT JOIN vendor v ON p.vendor = v.id
                           WHERE p.status = 1 AND p.isDone = 0 and v.status=1
                           and s.LHO like '".$assignedLho."'
                           GROUP BY p.vendor
                           ");
}else{
    $sql = mysqli_query($con, "SELECT p.vendor, v.status, COUNT(1) as totalSites 
                           FROM projectInstallation p
                           LEFT JOIN vendor v ON p.vendor = v.id
                           WHERE p.status = 1 AND p.isDone = 0 and v.status=1 
                           GROUP BY p.vendor
                           ");    
}

while ($sql_result = mysqli_fetch_assoc($sql)) {
    $noRecordsFound = false; // Data was found, set the flag to false
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

// Check if no data was found
if ($noRecordsFound) {
    // Display "No Records Found" message with an image
    echo '<div class="col-sm-4">
            <div class="card">
                <div class="card-block">
                    <img src="assets/noRecords.png" alt="No Records Found" style="max-width: 100%;">
                </div>
            </div>
          </div>';

    echo '<div class="col-sm-8">
            <div class="card">
                <div class="card-block">
                    <h6 class="strong">Installation Calls with Most Pending time</h6>
                    <span style="color:red;font-size: 10px;">(Max 7 Records here. Click the below button for more.. )</span>
                    <hr />
                    <div class="pendingInstallationDashboard overflow_auto">
                        <p>No Records Found</p>
                    </div>
                    <br />
                    <a href="pendingInstallation.php" class="btn btn-primary">View All Pending Installation</a>
                </div>
            </div>
          </div>';
} else {
    // Data was found, display the charts and table
    $sqlStatement = ""; // Initialize the SQL statement as an empty string
    if($assignedLho){
        $sqlStatement = "SELECT * FROM projectInstallation a INNER JOIN sites s ON a.atmid=s.atmid WHERE a.isDone = 0 and s.LHO like '".$assignedLho."' ORDER BY a.created_at ASC ";    
    } else {
        $sqlStatement = "SELECT * FROM projectInstallation WHERE isDone = 0 ORDER BY created_at ASC ";    
    }
    
    echo '
          <div class="col-sm-4">
              <div class="card">
                  <div class="card-block">
                      <div id="container" style="height: 400px;margin: 0px auto;overflow: hidden;"></div>
                      <form action="exportPendingSites.php" method="POST">
                          <input type="hidden" name="exportSql" value="'.$sqlStatement.'">
                          <input type="submit" name="exportsites" class="btn btn-primary" value="Export Data">
                      </form>
                  </div>
              </div>
          </div>';

    echo '<div class="col-sm-8">
              <div class="card">
                  <div class="card-block">
                      <h6 class="strong">Installation Calls with Most Pending time</h6>
                      <span style="color:red;font-size: 10px;">(Max 7 Records here. Click the below button for more.. )</span>
                      <hr />
                      <div class="pendingInstallationDashboard overflow_auto">
                          <table class="table table-bordered table-striped table-hover dataTable js-exportable no-footer table-xs">
                          
                              <thead>
                                  <tr class="table-primary">
                                      <th> Vendor </th>
                                      <th> Atmid </th>
                                      <th> Pending From </th>
                                      <th> Duration </th> <!-- New column -->
                                      <th> SBIN Ticket ID </th>
                                  </tr>
                              </thead>
                              <tbody>';
    
    $i = 1;
    
    if($assignedLho){
        $pendingInstallationSql = mysqli_query($con, "select 
        p.vendor,p.atmid,p.created_at,p.sbiTicketId,v.status
        from projectInstallation p
        INNER JOIN sites s ON p.atmid = s.atmid
        LEFT JOIN vendor v ON p.vendor = v.id
        where p.isDone=0 and v.status=1 and s.LHO like '".$assignedLho."' order by p.created_at asc limit 7");
    } else {
        $pendingInstallationSql = mysqli_query($con, "select 
        p.vendor,p.atmid,p.created_at,p.sbiTicketId,v.status
        from projectInstallation p 
        LEFT JOIN vendor v ON p.vendor = v.id
        where isDone=0 and v.status=1 order by created_at asc limit 7");
    }
    
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
    
            echo '<tr>
                    <td class="strong">'.$vendorName.'</td>
                    <td>'.$atmid.'</td>
                    <td>'.$created_at.'</td>
                    <td>'.$duration.'</td> <!-- Display the calculated duration -->
                    <td>'.$sbiTicketId.'</td>
                  </tr>';
    
            $i++;
        }
    }
    
    echo '</tbody>
          </table>  
          </div>
          <br />
          <a href="pendingInstallation.php" class="btn btn-primary"> View All Pending Installation </a>
      </div>
  </div>';

    echo '
          <script>
              var chartData = '.json_encode($totalPendingInstallation, JSON_NUMERIC_CHECK).';
              Highcharts.chart("container", {
                  title: {
                      text: "Pending Installations"
                  },
                  xAxis: {
                      categories: '.json_encode($categories).'
                  },
                  series: [{
                      type: "pie",
                      allowPointSelect: true,
                      keys: ["name", "y", "selected", "sliced"],
                      data: chartData,
                      showInLegend: true
                  }],
                  credits: {
                      enabled: false
                  },
                  tooltip: {
                      pointFormat: "<b>{point.name}</b>: {point.y}"
                  }
              });
          </script>';
}
?>

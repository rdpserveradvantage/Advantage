<?php include('header.php'); ?>

<style>
    html{
/*text-transform: inherit !important;*/
    }
</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>

<script>
    // PHP Data to be passed to JavaScript for Highcharts
    var vendorsData = <?php
        $vendorData = array();
        $query = "
            SELECT
                v.vendorName,
                COUNT(DISTINCT s.id) AS totalAllocatedSites,
                COUNT(DISTINCT CASE WHEN s.delegatedByVendor = 1 THEN s.id END) AS engtotalAllocatedSites,
                COUNT(DISTINCT CASE WHEN s.delegatedByVendor = 1 AND s.isFeasibiltyDone = 1 THEN s.id END) AS totalFeasibilityCount
            FROM vendor v
            LEFT JOIN sites s ON v.id = s.delegatedToVendorId
            WHERE v.status = 1
            GROUP BY v.id, v.vendorName";
        $result = mysqli_query($con, $query);
        while ($vendor = mysqli_fetch_assoc($result)) {
            $vendorData[] = array(
                'name' => $vendor['vendorName'],
                'y' => (int)$vendor['totalAllocatedSites'],
                'drilldown' => $vendor['vendorName']
            );
        }
        echo json_encode($vendorData);
    ?>;
</script>
<div class="pcoded-content">
  <div class="pcoded-inner-content">
    <div class="main-body">
      <div class="page-wrapper">
        <div class="page-body">
          <div class="row" id="part11">
            <div class="col-sm-8 overflow_auto">
              <table class="table table-hover table-styling table-xs">
                <thead>
                  <tr class="table-primary">
                    <th>Srno</th>
                    <th>Vendor</th>
                    <th>Sites Allocated</th>
                    <th>Allocated To Engineer</th>
                    <th>Feasibility Count</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $i = 1;
                  $result = mysqli_query($con, $query);
                  while ($vendor = mysqli_fetch_assoc($result)) :
                  ?>
                    <tr>
                      <td><?= $i++; ?></td>
                      <td><?= $vendor['vendorName']; ?></td>
                      <td><?= $vendor['totalAllocatedSites']; ?></td>
                      <td><?= $vendor['engtotalAllocatedSites']; ?></td>
                      <td><?= $vendor['totalFeasibilityCount']; ?></td>
                    </tr>
                  <?php endwhile; ?>
                </tbody>
              </table>
            </div>
            <div class="col-sm-4">
              <div id="pieChart"></div>
            </div>
          </div>
          <hr />
          <div class="row">
              

          <?
          $vendorSql = mysqli_query($con,"select * from vendor where status=1");
          while($vendorSql_result = mysqli_fetch_assoc($vendorSql)){ 
          $id = $vendorSql_result['id'];
          $vendorName = $vendorSql_result['vendorName'];
          ?>
          
<div class="col-xl-3 col-md-6">
    <div class="card">
        <div class="card-block text-center">
            <i class="feather icon-mail text-c-lite-green d-block f-40"></i>
            <h4 class="m-t-15"><span class="text-c-lite-green"><? echo $vendorName; ?></span>
            </h4>
            
            <a href="javascript:void(0);" class="btn btn-primary btn-sm btn-round" onclick="newwin('vendorPortal.php?id=<? echo $id; ?>','display',600,600)"> 
            <font size="+1">View Portal</font></a>
            
        </div>
    </div>

</div>

              
          <? } ?>
          </div>


  


  
<script>

function newwin(url,winname,w,h){
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    var targetWin = window.open (url, winname, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=1, resizable=yes, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);  
}
 
 
    </script>
    
    
    
        </div>
      </div>
    </div>
  </div>
</div>

<script>
 Highcharts.chart('pieChart', {
            chart: {
                type: 'pie'
            },
            title: {
                text: 'Sites Allocation by Vendors',
                verticalAlign: 'bottom',
                align: 'center', 

                
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                    }
                }
            },
            exporting: {
                enabled: true, // Enable exporting module
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadCSV', // Add 'Download CSV' option to the menu
                            'downloadPNG', // Add 'Download PNG image' option to the menu
                            'downloadJPEG', // Add 'Download JPEG image' option to the menu
                            'downloadPDF', // Add 'Download PDF document' option to the menu
                        ]
                    }
                }
            },
            series: [{
                name: 'Vendors',
                colorByPoint: true,
                data: vendorsData
            }],
            credits: {
            enabled: false
        }
        });
</script>

<?php include('footer.php'); ?>

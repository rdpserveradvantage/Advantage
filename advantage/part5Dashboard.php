<? include('config.php');





$query1 = "select count(1) as count from mis where status='open'";
$query2 = "select count(1) as count from mis where status='close'";
$query3 = "SELECT COUNT(1) AS count FROM projectInstallation where isDone=1 and status=1";
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
                                                <h5 class="font-size-16 mb-0"><?= $results[$i]; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
<? }




// todays ESD


// todays ASD


// high aging calls




echo '
<div class="col-sm-12">
<div class="card">
<div class="card-header">
    <h5>Recent Open Calls</h5>
    <hr />
</div>

<div class="card-block" style="overflow:auto;">


';

$agingCount = 1;
$highagingsql = mysqli_query($con, "SELECT a.atmid, MAX(c.created_at) as latest_created_at,a.created_at, a.lho, a.state, a.city, a.location, b.ticket_id, b.id, a.isRead 
FROM mis a 
INNER JOIN mis_details b ON a.id = b.mis_id 
LEFT JOIN mis_history c ON c.mis_id = a.id
WHERE a.status <> 'close' GROUP BY a.atmid ORDER BY latest_created_at DESC
limit 20 ");
if (mysqli_num_rows($highagingsql) > 0) {

    echo '
<table class="table table-hover table-styling table-xs">
<thead>
<tr class="table-primary">
    <th>Sr No</th>
    <th>ATMID</th>
    <th>Ticket ID</th>
    <th>Created At</th>
    <th>Aging</th>
    <th>lastUpdate</th>
    <th>LHO</th>
    <th>City</th>
    <th>State</th>
    <th>Location</th>
</tr>
</thead>
<tbody>
';

    while ($highagingsql_result = mysqli_fetch_assoc($highagingsql)) {

        $createdAtTimestamp = strtotime($highagingsql_result['created_at']);
        $currentTime = time();
        $agingInSeconds = $currentTime - $createdAtTimestamp;

        $days = floor($agingInSeconds / (60 * 60 * 24));
        $hours = floor(($agingInSeconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($agingInSeconds % (60 * 60)) / 60);
        $seconds = $agingInSeconds % 60;

        $agingFormatted = sprintf("%dd %02dh %02dm %02ds", $days, $hours, $minutes, $seconds);



        $ticket_id = $highagingsql_result['ticket_id'];
        $detail_id = $highagingsql_result['id'];
        $lastUpdate = $highagingsql_result['latest_created_at'];


        if (strtolower($highagingsql_result['isRead']) == 'unread') {
            $className = 'unread';
        } else {
            $className = 'read';
        }

        echo "<tr class='{$className}'>
                <td>{$agingCount}</td>
                <td>{$highagingsql_result['atmid']}</td><td>";

        if ($SERVICE_LEVEL != 5) {
            echo "<a href=\"mis_details.php?id={$detail_id}\" target=\"_blank\">{$ticket_id}</a>";
        } else {
            echo "<a href=\"#\" target=\"_blank\">{$ticket_id}</a>";
        }


        echo "</td><td>{$highagingsql_result['created_at']}</td>
<td>{$agingFormatted}</td>

<td>{$lastUpdate}</td>

<td>{$highagingsql_result['lho']}</td>
<td>{$highagingsql_result['city']}</td>
<td>{$highagingsql_result['state']}</td>
<td>{$highagingsql_result['location']}</td>
</tr>";


        $agingCount++;
    }
    echo '</tbody>
</table>';


} else {

    echo '
                                        
<div class="noRecordsContainer">
<img src="assets/no_records.jpg">
</div>
</div>';

}



echo '
</div>
</div>
';

?>
<style>
    /* Add styles for unread rows */
    .table-styling tbody tr.unread {
        background-color: #ffcccc;
        /* Light red background for unread rows */
        font-size: 14px;
    }

    .table-styling tbody tr {
        font-size: 13px;
        background-color: #f2f6fc;
    }

    /* Style for unread ticket IDs */
    .table-styling tbody tr.unread td:nth-child(3) a {
        font-weight: bold;
        /* Make unread ticket IDs bold */
        color: #ff0000;
        /* Red color for unread ticket IDs */
    }
</style>
<?
echo '
    <div class="card">
        <div class="card-header">
            <h5>Call From Bank</h5>
        </div>
    
        <div class="card-block" style="overflow:auto;">
        
    
        ';

$agingCount = 1;
$highagingsql = mysqli_query($con, "select a.created_at,a.atmid,a.lho,a.state,a.city,a.location,b.ticket_id,b.id from mis a
        INNER JOIN mis_details b on a.id=b.mis_id
        where a.status='open' and a.call_receive_from='Customer / Bank' order by a.created_at asc limit 10 ");
if (mysqli_num_rows($highagingsql) > 0) {

    echo '
<table class="table table-hover table-styling table-xs">
    <thead>
        <tr class="table-primary">
            <th>Sr No</th>
            <th>ATMID</th>
            <th>Ticket ID</th>
            <th>Created At</th>
            <th>Aging</th>
            <th>LHO</th>
            <th>City</th>
            <th>State</th>
            <th>Location</th>
        </tr>
    </thead>
    <tbody>
';

    while ($highagingsql_result = mysqli_fetch_assoc($highagingsql)) {


        $createdAtTimestamp = strtotime($highagingsql_result['created_at']);
        $currentTime = time();
        $agingInSeconds = $currentTime - $createdAtTimestamp;

        $days = floor($agingInSeconds / (60 * 60 * 24));
        $hours = floor(($agingInSeconds % (60 * 60 * 24)) / (60 * 60));
        $minutes = floor(($agingInSeconds % (60 * 60)) / 60);
        $seconds = $agingInSeconds % 60;

        $agingFormatted = sprintf("%dd %02dh %02dm %02ds", $days, $hours, $minutes, $seconds);



        $ticket_id = $highagingsql_result['ticket_id'];
        $detail_id = $highagingsql_result['id'];


        echo "<tr>
        <td>{$agingCount}</td>
        <td  class='strong'>{$highagingsql_result['atmid']}</td><td>";

        if ($SERVICE_LEVEL != 5) {
            echo "<a href=\"mis_details.php?id={$detail_id}\">{$ticket_id}</a>";
        } else {
            echo "<a href=\"#\">{$ticket_id}</a>";
        }


        echo "</td><td>{$highagingsql_result['created_at']}</td>
        <td>{$agingFormatted}</td>
        <td>{$highagingsql_result['lho']}</td>
        <td>{$highagingsql_result['city']}</td>
        <td>{$highagingsql_result['state']}</td>
        <td>{$highagingsql_result['location']}</td>
    </tr>";


        $agingCount++;
    }
    echo '</tbody>
    </table>';


} else {

    echo '
                                                
    <div class="noRecordsContainer">
        <img src="assets/noRecords.png">
    </div>';

}


echo '
        </div>
    </div>
    

    ';
    
    
    ?>
    
    <!--<div id="misdonutChart"></div>-->

    <div class="card">
        <div class="card-block">
            <div id="misdonutChart" ></div>
        </div>
    </div>


<? 
// Query to get type and count data
$query = "SELECT type, COUNT(1) AS count FROM mis_history WHERE type<>'Mail Update' GROUP BY type";
$result = mysqli_query($con, $query);


// Fetch data into an array
$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}
?>



<script>
// Data from PHP
var chartData = <?php echo json_encode($data); ?>;

// Create an array of data points
var donutChartData = chartData.map(function(item) {
    return {
        name: item.type,
        y: parseFloat(item.count) // Convert count to a number
    };
});

// Initialize Highcharts donut chart
Highcharts.chart('misdonutChart', {
    chart: {
        type: 'pie',
        options3d: {
            enabled: true,
            alpha: 45
        }
    },
    title: {
        text: 'Type Counts'
    },
    plotOptions: {
        pie: {
            innerSize: 100, // Adjust this value to control the size of the hole in the center (donut hole)
            depth: 45,
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.percentage:.1f} % ({point.y})'
            }
        }
    },
    legend: {
        align: 'right', // Adjust the position of the legend
        verticalAlign: 'middle',
        layout: 'vertical',
        itemStyle: {
            fontWeight: 'normal'
        },
        labelFormatter: function() {
            var name = this.name;
            var color = this.color;
            return '<div style="display: flex; align-items: center;"><div style="width: 10px; height: 10px; background: ' + color + '; margin-right: 5px;"></div>' + name + '</div>';
        }
    },
    series: [{
        name: 'Count',
        data: donutChartData
    }],
    credits: {
            enabled: false
        }
});
</script>